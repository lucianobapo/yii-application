<?php

class UserRegisterController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	public function actions()
	{
		return array(
			'buscaPorCep'=>'ext.correios.actions.BuscaPorCepAction',

		);
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','admin','view','create','update','delete'),
				'roles'=>array('admin'),
				//'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','buscaPorCep'),
				//'roles'=>array('admin'),
				'users'=>array('?'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if (Yii::app ()->request->isAjaxRequest) {
			// outputProcessing = true because including css-files ...
			$this->renderPartial ( 'view', array (
					'model' => $this->loadModel ( $id )
			), false, true );
			// js-code to open the dialog
			if (! empty ( $_GET ['asDialog'] ))
				echo CHtml::script ( '$("#dlg-address-view").dialog("open")' );
			Yii::app ()->end ();
		} else
			$this->render ( 'view', array (
					'model' => $this->loadModel ( $id )
			) );
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		Yii::beginProfile(get_class($this));
		if (!isset(Yii::app()->user->dados)) {
			throw new CHttpException(404,Helpers::t('app', 'appFormLabel5'));
			return;
		}

		$model=new User('createDelivery');
		//echo '<pre>'.CVarDumper::dumpAsString($_POST).'</pre>';
		$modelParceiro=new DeliveryParceiro('create');

		$modelAssign=new Authassignment();


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if( (isset($_POST['User']))&&(isset($_POST['DeliveryParceiro'])) )
		{
			$transaction=$model->dbConnection->beginTransaction();

			$model->attributes=$_POST['User'];
			$modelParceiro->attributes=$_POST['DeliveryParceiro'];

			$modelParceiro->tipo_cliente=1;
			$model->email=$modelParceiro->email;

			//echo '<pre>'.CVarDumper::dumpAsString($model).'</pre>';
			
			if ( ($model->save())&&($modelParceiro->save()) ){
				
				$modelAssign->userid=$model->id;
				$modelAssign->itemname='erpnetIlhanetDelivery';
				$model->id_cliente=$modelParceiro->id;
                //$model->password=md5($model->password);

                $modelEndereco=new DeliveryEndereco('create');
                $modelEndereco->id_entidade=$modelParceiro->id;
                $modelEndereco->usuario=$model->social_identifier;
                $modelEndereco->principal=1;
                $modelEndereco->cep=$modelParceiro->cep;
                $modelEndereco->logradouro=$modelParceiro->endereco;
                $modelEndereco->bairro=$modelParceiro->custom3;
                $modelEndereco->cidade=$modelParceiro->cidade;
                $modelEndereco->estado=$modelParceiro->estado;
                $modelEndereco->complemento=$modelParceiro->custom4;
				
				if ( ($model->save())&&($modelAssign->save())&&($modelEndereco->save()) ) {
					$transaction->commit();

                    //Log de evento
                    Yii::trace('Usuário registrado: '.Yii::app()->name.' - '.date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'].".<br>\nDados: ".'<pre>'.CVarDumper::dumpAsString(Yii::app()->user->dados).'</pre>','application.delivery');

					Yii::app()->user->setState('dados', null);
					$this->redirect(Yii::app()->createUrl("/site/authenticate", array("provider"=>$model->provider)));
				} else {
					if ($transaction->getActive()) $transaction->rollback();
					//Converte data de aniversário para string
					if ($modelParceiro->aniversario!='')
						$modelParceiro->aniversario = Yii::app()->dateFormatter->formatDateTime($modelParceiro->aniversario,'medium',null);

					//echo '<pre>'.CVarDumper::dumpAsString($model).'</pre>';
					//echo '<pre>'.CVarDumper::dumpAsString($modelAssign).'</pre>';
				}
				
			}else {
				if ($transaction->getActive()) $transaction->rollback();
				//Converte data de aniversário para string
				if ($modelParceiro->aniversario!='')
					$modelParceiro->aniversario = Yii::app()->dateFormatter->formatDateTime($modelParceiro->aniversario,'medium',null);
				//echo '<pre>'.CVarDumper::dumpAsString($modelParceiro).'</pre>';
			}
		}else{
			//Log de evento
			Yii::trace('Usuário iniciou o registro: '.Yii::app()->name.' - '.date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'].".<br>\nDados: ".'<pre>'.CVarDumper::dumpAsString(Yii::app()->user->dados).'</pre>','application.delivery');
		}
		
		//echo '<pre>'.CVarDumper::dumpAsString($_POST).'</pre>';
		$this->render('create',array(
				'model'=>$model,
				'modelParceiro'=>$modelParceiro,
				'modelAssign'=>$modelAssign,
		));
		Yii::endProfile(get_class($this));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()) {
				EQuickDlgs::checkDialogJsScript();
				$this->redirect(array('admin'));
			}
		}

		EQuickDlgs::render('update',array('model'=>$model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{		
		$this->actionCreate();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		//if($model===null)
		if ( ($model===null) || ( (Yii::app()->user->empresa!=$model->empresa) && (!Yii::app()->user->checkAccess('admin')) ) )
			throw new CHttpException(404,utf8_encode(Yii::t('app', 'appFormLabel5', array(), 'i18n')));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
