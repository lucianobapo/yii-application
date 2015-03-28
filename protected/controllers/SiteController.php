<?php

class SiteController extends Controller
{
	public function filters()
	{
		return array(
			//'Http +index',
			array(
				'application.components.FilterHttp +index,logout',
			),
			array('application.components.FilterHttps +autenticate, endpoint',),
		);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		Yii::beginProfile(get_class($this));
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		//$this->render('/'.Controller::getModuleName().'/default/home');
		//$model=new User('search');
		if ( (!Helpers::getModuleName())||(!isset(Yii::app()->modules[Helpers::getModuleName()])) )
			//$this->render('index',array('model'=>$model));
			$this->render('index');
			//die('a');
		else {
			$home = new HomeController('HomeController');
			$home->actionIndex();
			//$this->redirect(array('/'.Helpers::getModuleName()));
		}
		Yii::endProfile(get_class($this));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8\r\n";

				//mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Helpers::sendMail(array('email'=>Yii::app()->params['adminEmail'],'name'=>'Contato: '.$_SERVER['HTTP_HOST']),$subject,$headers.$model->body,$erro);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionExecLogin()
	{
		$model=new LoginForm;
		$model->setScenario('login');
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			
			if($model->validate() && $model->login()){
				
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
		
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	/*
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}*/

	public function actionTrocaSenha()
	{
		$model=new LoginForm;
		$model->setScenario('trocarSenha');

		$model2=User::model()->findByAttributes(array('username'=>Yii::app()->user->name));
		$model2->setScenario('trocarSenha');
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			$model2->attributes=array('password'=>$model->new_password,'trocar_senha'=>0);
			// validate user input and redirect to the previous page if valid
			if ( ($model->validate())&&($model2->save()) ){
				Yii::app()->user->setFlash('troca','A senha foi trocada com sucesso.');
				if (!Helpers::sendMail(array('email'=>$model2->email,'name'=>$model->username),
						'Troca de Senha - '.Yii::app()->name,
						"A senha foi trocada com sucesso.<br>\nSite: ".$_SERVER['HTTP_HOST'],$erro))
					Yii::app()->user->setFlash('erro','Erro: Não foi possível mandar o e-mail para: '.$model2->email.' -- '.$erro);
			} else $model->addError('old_password','Não foi possível trocar a senha.');
		}
		// display the login form
		$this->render('trocaSenha',array('model'=>$model));
	}
	
	
	// important! all providers will access this action, is the route of 'base_url' in config
	public function actionEndpoint(){

		//desativa rastreamento de buscadores
		$config_gen['params']['metaRobots']='noindex, nofollow';
		Yii::app()->hybridAuth->endPoint();
	}
	
	public function actionAuthenticate($provider='Facebook'){
		Yii::beginProfile(get_class($this));

		//desativa rastreamento de buscadores
		$config_gen['params']['metaRobots']='noindex, nofollow';

		if(!Yii::app()->user->isGuest || !Yii::app()->hybridAuth->isAllowedProvider($provider)){
			Helpers::setFlash('erro',Helpers::t('appUi','Erro na Autenticação'));
			$this->redirect(Yii::app()->homeUrl);
		}

		//Log de evento
		Yii::trace('Usuário iniciou o autenticação: '.Yii::app()->name.' - '.date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'].".<br>\nProvider: ".$provider,'application.delivery');

		Yii::app()->hybridAuth->showError=!Helpers::isOnline();
	
		if(Yii::app()->hybridAuth->isAdapterUserConnected($provider)){
			if ( (isset(Yii::app()->user->dados))&&(Yii::app()->user->dados['provider']==$provider) ){
				Yii::app()->hybridAuth->logoutAllProviders();
				$this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/userRegister/create'));
			}

			$socialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);
			//Yii::app()->hybridAuth->logoutAllProviders();
			//die ('<pre>'.CVarDumper::dumpAsString($socialUser).'</pre>');
			if(isset($socialUser)){
				// find user from db model with social user info
				//$user = User::model()->findBySocial($provider, $socialUser->identifier);
				$user = User::model()->findByAttributes(array(
						'social_identifier'=>$socialUser->identifier,
						'provider'=>$provider));
				if($user===null){
					// if not exist register new user with social user info.
					foreach ($socialUser as $key=>$value)
						$envia[$key]=$value;
					$envia['provider']=$provider;
					Yii::app()->user->setState('dados', $envia);
					//echo '<pre>'.CVarDumper::dumpAsString($envia).'</pre>';
					Yii::app()->hybridAuth->logoutAllProviders();
					$this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/userRegister/create'));
				}else{
					Yii::app()->user->setState('dados', null);
					$identity = new UserIdentity($socialUser->displayName,null,$socialUser->identifier);
					$identity->authenticate('social');
					switch ($identity->errorCode) {
						case UserIdentity::ERROR_NONE:
							Yii::app()->user->login($identity,0);
							//$this->redirect(Yii::app()->request->urlReferer);
							//echo '<pre>'.CVarDumper::dumpAsString($socialUser).'</pre>';
							Helpers::setFlash('success',Helpers::t('appUi','Seja Bem-Vindo {user}!',array('{user}'=>Yii::app()->user->name)));
							Yii::app()->hybridAuth->logoutAllProviders();
							//$this->redirect(Yii::app()->homeUrl);
							if (Yii::app()->user->returnUrl==Yii::app()->homeUrl)
								$this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/create'));
							else
								$this->redirect(Yii::app()->user->returnUrl);
							//
							break;
						case UserIdentity::ERROR_USERNAME_BLOCKED:
							Helpers::setFlash('erro',$identity->errorMessage);
							Yii::app()->hybridAuth->logoutAllProviders();
							$this->redirect(Yii::app()->homeUrl);
							break;
						default:
							Helpers::setFlash('erro',Helpers::t('appUi','Erro durante autenticação. Contate o Administrador do Site.'));
							Yii::app()->hybridAuth->logoutAllProviders();
							$this->redirect(Yii::app()->homeUrl);
							break;
					}
				}
			} else {
				Helpers::setFlash('erro',Helpers::t('appUi','Erro ao Acessar Perfil'));
				Yii::app()->hybridAuth->logoutAllProviders();
				$this->redirect(Yii::app()->homeUrl);
			}
		} else {
			Helpers::setFlash('erro',Helpers::t('appUi','Erro: Usuário não conectado'));
			Yii::app()->hybridAuth->logoutAllProviders();
			$this->redirect(Yii::app()->homeUrl);
		}
		Yii::endProfile(get_class($this));
	}
	
	public function actionLogout(){

		if ( (isset(Yii::app()->hybridAuth))&&(Yii::app()->hybridAuth->getConnectedProviders()) ){
			Yii::app()->hybridAuth->logoutAllProviders();
		}
	
		Yii::app()->user->logout();
		Yii::app()->user->setState('dados', null);
		//$this->redirect('/');
		$this->redirect(Yii::app()->homeUrl);
	}
}