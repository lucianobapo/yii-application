<?php

class DeliveryPedidoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
				'actions'=>array('confirma','create','cancel','update','list'),
				'roles'=>array('deliveryPedidos'),
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
	public function actionCreate($id=null)
	{
		Yii::beginProfile(get_class($this));
		$erpnet=Yii::app()->getModule('erpnet');

		//protege a entrada inválida
		if ( ($id!=null) &&
			( ( ($ordem=ErpnetOrdem::model()->findByPk($id))==null)
				|| ($ordem->status_cancelado==1)
				|| ($ordem->status_fechado==0)
				|| ($ordem->usuario!=Yii::app()->user->social_identifier) ) ) {

			Helpers::setFlash('erro',Helpers::t('appUi', 'Erro: Pedido Inválido.'));
            $this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/create'));
			//$this->redirect(Yii::app()->homeUrl);
			return;
		}

		Yii::trace('Usuário iniciou o pedido: '.Yii::app()->name.' - '.date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'],'application.delivery');

		//Enviar sugestão
		if ( (isset($_POST['sugestao'])) && ($_POST['sugestao']!='') && (Helpers::enviaSugestao($_POST['sugestao']))) {
			Helpers::setFlash('sugestao',Helpers::t('appUi', 'Sugestão enviada com sucesso.'));
		}

		Yii::import('application.modules.erpnet.controllers.ErpnetOrdemController');
		$contr= new ErpnetOrdemController('erpnetOrdem');
		$action='';
		if ($id===null){
			$contr->preparaOrdem('create',null,'venda');
		} else {
			$contr->model=ErpnetOrdem::model()->findByPk($id);
			$contr->model->data_termino=Yii::app()->dateFormatter->formatDateTime($contr->model->data_termino,'medium',null);
			$action=$this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/create' );
		}

		$produtos=ErpnetProduto::getProdutos();
		$index=0;
		foreach($produtos as $produto) {
			//se não achar os itens, atribui um model em branco
			$data= new DbAccess();
			if ( ($contr->modelOrdemItem[$index]=$data->getErpnetOrdemItem($produto->id,$id))===null) {
				//echo '<pre>'.CVarDumper::dumpAsString($contr->modelOrdemItem).'</pre>';
				$contr->modelOrdemItem[$index]=new ErpnetOrdemItem('venda');
				$contr->modelOrdemItem[$index]->quantidade=0;
			}
			$index=$index+1;
		}
		
		if(isset($_POST['ErpnetOrdem'])) {
			$transaction=$contr->model->dbConnection->beginTransaction();
			if ( (isset($_POST['submit'])) && ($_POST['submit']=='pagseguro') ) {
				$contr->model->pagamento='pagseguro';
				$redirectUpdateAction='pagseguro';
			}else{
				//$contr->model->pagamento='avistad';
				$redirectUpdateAction='confirma';
			}
			$contr->gravaOrdem('venda',$transaction);
			if (isset($_POST['ErpnetOrdemItem'])) {
				$sucesso='';
				$valor=0;
				$nao_apagar=null;
				foreach ($_POST['ErpnetOrdemItem'] as $i => $value)
					if ( (isset($_POST['ErpnetOrdemItem'][$i])) 
						&& ($_POST['ErpnetOrdemItem'][$i]['id_produto']!='')
						&& ($_POST['ErpnetOrdemItem'][$i]['quantidade']>0) ){
						
						$contr->modelOrdemItem[$i]=new ErpnetOrdemItem('venda');
						$contr->modelOrdemItem[$i]->attributes=$_POST['ErpnetOrdemItem'][$i];
						$contr->modelOrdemItem[$i]->id_ordem=$contr->model->id;
						
						$contr->modelOrdemItem[$i]->data_termino=CDateTimeParser::parse($contr->model->data_termino, Yii::app()->locale->dateFormat);
						
						$contr->gravaOrdemItem('venda',$transaction,$i,$valor,$nao_apagar,$sucesso);
					}

				$contr->finalizaOrdem(Helpers::t('erpnetUi', 'viewCreateFlash'),null,$redirectUpdateAction,$transaction,$valor,$sucesso,false,'deliveryPedido');
			
			}
		}

		$aux=array(
			'model'=>$contr->model,
			'modelItem'=>$contr->modelOrdemItem,
			'action'=>$action,//'debug'=>$_POST,
		);
        if ($id!==null) $aux['id']=$id;
		//die('<pre>'.CVarDumper::dumpAsString($contr->id).'</pre>');
		$this->render('create',$aux);
		Yii::endProfile(get_class($this));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$erpnet=Yii::app()->getModule('erpnet');
		Yii::import('application.modules.erpnet.controllers.ErpnetOrdemController');
		//Yii::import('application.modules.erpnet.models.ErpnetOrdem');
				
		$contr= new ErpnetOrdemController('ErpnetOrdemController');
		$contr->preparaOrdem('update','/'.Helpers::getModuleName(),'venda',$id);
		
		if ( ($contr->model->status_cancelado==1)||($contr->model->status_fechado==1)||($contr->model->usuario!=Yii::app()->user->social_identifier) ){
			Yii::app()->user->setFlash('erro',Helpers::t('appUi', 'Erro: Pedido Inválido.'));
			$this->redirect(array('/'.Helpers::getModuleName()));
			return;
		}
		
		//*
		//Yii::import('application.modules.erpnet.models.ErpnetProduto');
		//Yii::import('application.modules.erpnet.models.ErpnetOrdemItem');
		$produtos=ErpnetProduto::getProdutos();
		$index=0;
		foreach($produtos as $produto) {
			if ( ($contr->modelOrdemItem[$index]=ErpnetOrdemItem::model()->findByAttributes(array('id_produto'=>$produto->id,'id_ordem'=>$id))	)===null) {
				$contr->modelOrdemItem[$index]=new ErpnetOrdemItem('venda');
				$contr->modelOrdemItem[$index]->quantidade=0;
			}
			//else $contr->modelOrdemItem[$index]->setScenario('venda');
			$index=$index+1;
		}
		//*/
		//echo '<pre>'.CVarDumper::dumpAsString($contr->modelOrdemItem).'</pre>';
		//$models=array();
		//$contr->preparaOrdemItem('update','venda',$models,$id);
		
		if(isset($_POST['ErpnetOrdem'])) {
			$transaction=$contr->model->dbConnection->beginTransaction();
			$contr->gravaOrdem('venda',$transaction);
			if (isset($_POST['ErpnetOrdemItem'])) {
				$sucesso='';
				$valor=0;
				$nao_apagar=null;
				foreach ($_POST['ErpnetOrdemItem'] as $i => $value)
					if ( (isset($_POST['ErpnetOrdemItem'][$i]))
						&& ($_POST['ErpnetOrdemItem'][$i]['id_produto']!='')
						&& ($_POST['ErpnetOrdemItem'][$i]['quantidade']>0) ){
		
						$contr->modelOrdemItem[$i]=new ErpnetOrdemItem('venda');
						$contr->modelOrdemItem[$i]->attributes=$_POST['ErpnetOrdemItem'][$i];
						$contr->modelOrdemItem[$i]->id_ordem=$contr->model->id;
		
						$contr->modelOrdemItem[$i]->data_termino=CDateTimeParser::parse($contr->model->data_termino, Yii::app()->locale->dateFormat);
		
						$contr->gravaOrdemItem('venda',$transaction,$i,$valor,$nao_apagar,$sucesso);
					}
				if ($transaction->getActive()) $contr->apagaItens($nao_apagar);
				$contr->finalizaOrdem(Helpers::t('erpnetUi', 'viewCreateFlash'),null,'confirma',$transaction,$valor,$sucesso,false,'deliveryPedido');
					
			}
		}
		
		//$contr->renderizaOrdem($fileFormHeader,$fileForm,$tabularAction,$tabularInput,$scenario,$models,false);
		
		//echo '<pre>'.CVarDumper::dumpAsString($_POST).'</pre>';
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		//echo '<pre>'.CVarDumper::dumpAsString($contr->modelOrdemItem).'</pre>';
		
		
		$this->render('update',array(
				'model'=>$contr->model,'modelItem'=>$contr->modelOrdemItem,
		));
		/*
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DeliveryPedido']))
		{
			$model->attributes=$_POST['DeliveryPedido'];
			if($model->save()) {
				EQuickDlgs::checkDialogJsScript();
				$this->redirect(array('admin'));
			}
		}

		EQuickDlgs::render('update',array('model'=>$model));
		*/
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
	
	public function actionCancel($id)
	{
		
		Yii::import('application.modules.erpnet.models.ErpnetOrdem');
		$model=ErpnetOrdem::model()->findByPk($id);
		
		if ( ($model->status_cancelado==1)||($model->status_fechado==1)||($model->usuario!=Yii::app()->user->social_identifier) ){
			Yii::app()->user->setFlash('erro',Helpers::t('appUi', 'Erro: Pedido Inválido.'));
			$this->redirect(array('/'.Helpers::getModuleName()));
			return;
		}
		
		$model->status_cancelado=1;
		if ($model->save()) {
			Yii::app()->user->setFlash('alert',Helpers::t('appUi', 'Pedido nº{pedido} cancelado com sucesso.',array('{pedido}'=>$id)));
			//$this->redirect(array('/'.Helpers::getModuleName()));
            $this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/create'));
		}else{
			Yii::app()->user->setFlash('erro',Helpers::t('appUi', 'Erro ao cancelar o Pedido.'));
			//$this->redirect(array('/'.Helpers::getModuleName()));
            $this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/create'));
		}
	}

    public function actionConfirma($id=null)
    {
        $erpnet=Yii::app()->getModule('erpnet');
        //$model=new DeliveryEntrega;
        $modelOrdem=ErpnetOrdem::model()->findByPk($id);
        $parceiro=DeliveryParceiro::model()->findByPk($modelOrdem->id_cliente);
        //die('<pre>'.CVarDumper::dumpAsString($modelOrdem).'</pre>');

        if ( ($id===null) || ($modelOrdem->status_cancelado==1)||($modelOrdem->status_fechado==1)||($modelOrdem->usuario!=Yii::app()->user->social_identifier) ){
            Helpers::setFlash('erro',Helpers::t('appUi', 'Erro: Pedido Inválido.'));
            //die('<pre>'.CVarDumper::dumpAsString($modelOrdem).'</pre>');
            //$this->redirect(Yii::app()->homeUrl);
            $this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/create'));
            return;
        }

        $endereco=DeliveryEndereco::model()->findByAttributes(array(
            //'id_entidade'=>$parceiro->id,
            'usuario'=>Yii::app()->user->social_identifier,
            'principal'=>1,
        ));

        if(isset($_POST['ErpnetOrdem']))
        {
            //$transaction=$model->dbConnection->beginTransaction();
            //$model->attributes=$_POST['DeliveryEntrega'];
            $modelOrdem->status_fechado=$_POST['ErpnetOrdem']['status_fechado'];
            if ( ($modelOrdem->save()) ) {
                //$transaction->commit();

                Yii::trace("Pedido $id confirmado: ".Yii::app()->name.' - '.date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'],'application.delivery');

                $msg='';
                $msg=$msg.'<img width=100 height=100 src="'.$parceiro->custom1."\"><br>\n";
                $msg=$msg.'<h3>'.Helpers::t('appUi', 'Parabéns {nome}! Seu pedido nº{pedido} foi confirmado com sucesso. Segue abaixo os detalhes:',array('{pedido}'=>$id,'{nome}'=>$parceiro->nome))."</h3><br>\n";

                $msg=$msg."<br>\n<b>".Helpers::t('appUi','Endereço de entrega:')."</b><br>\n";
                $msg=$msg.Helpers::t('appUi', "CEP: {cep}",array('{cep}'=>$endereco->cep))."<br>\n";

                $msg=$msg.Helpers::t('appUi', "Logradouro: {endereco}, {complemento}",array('{endereco}'=>$endereco->logradouro,'{complemento}'=>$endereco->complemento),'i18n',null,false,true )."<br>\n";
                $msg=$msg.Helpers::t('appUi', "Bairro: {bairro}",array('{bairro}'=>$endereco->bairro),'i18n',null,false,true)."<br>\n";
                $msg=$msg.Helpers::t('appUi', "Cidade: {cidade}/{uf}",array('{cidade}'=>$endereco->cidade,'{uf}'=>$endereco->estado),'i18n',null,false,true)."<br>\n";

                $msg=$msg."<br>\n<b>".Helpers::t('appUi','Itens do pedido:')."</b><br>\n";
                $itens=ErpnetOrdemItem::model()->findAllByAttributes(array('id_ordem'=>$id));
                foreach ($itens as $key => $item){
                    $produto=ErpnetProduto::model()->findByPk($item->id_produto);
                    $msg=$msg.Helpers::t('appUi', " - {descricao}: {quantidade} x {valor}",array('{descricao}'=>$produto->descricao,'{quantidade}'=>$item->quantidade,'{valor}'=>CHtml::encode(Yii::app()->numberFormatter->formatCurrency($item->valor,'R$')) ),'i18n',null,false,true)."<br>\n";
                }
                $msg=$msg.'<b>'.Helpers::t('appUi', "Valor total: {valor}",array('{valor}'=>CHtml::encode(Yii::app()->numberFormatter->formatCurrency($modelOrdem->valor,'R$')) ))."</b><br>\n";

                if ($modelOrdem->pagamento=='vistad')
                    $msg=$msg.Helpers::t('appUi', 'Pagamento em dinheiro. Troco para: {valor}',array('{valor}'=>CHtml::encode(Yii::app()->numberFormatter->formatCurrency($modelOrdem->troco,'R$')) ))."<br>\n";
                if ($modelOrdem->pagamento=='vistacd')
                    $msg=$msg.Helpers::t('appUi', 'Pagamento com Cartão de Débito.')."<br>\n";
                if ($modelOrdem->pagamento=='vistacc')
                    $msg=$msg.Helpers::t('appUi', 'Pagamento com Cartão de Crédito.')."<br>\n";

                Helpers::sendMail(array('email'=>$parceiro->email,'name'=>$parceiro->nome),'Novo Pedido',($msg));

                Helpers::setFlash('success',Helpers::t('appUi','Pedido nº{pedido} realizado com sucesso! O acompanhamento da entrega será enviado para seu email: "{email}"',array('{email}'=>$parceiro->email,'{pedido}'=>$id)));

                //$this->redirect(Yii::app()->homeUrl);
                $this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/create'));
                //$this->redirect(array('/delivery'));
            } else {
                $transaction->rollback();
                Helpers::setFlash('erro',Helpers::t('appUi', 'Erro ao gravar Entrega.'));
                //$this->redirect(Yii::app()->homeUrl);
                $this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/create'));
                return;
            }

        } else {
            Yii::trace("Usuário iniciou a confirmação do pedido $id: ".Yii::app()->name.' - '.date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'],'application.delivery.entrega');

            //echo '<pre>'.CVarDumper::dumpAsString($user->email).'</pre>';

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);


            $this->render('confirma',array(
                'model'=>$modelOrdem,'id'=>$id,'parceiro'=>$parceiro,'endereco'=>$endereco,
            ));
        }

    }


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{		
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DeliveryPedido('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DeliveryPedido']))
			$model->attributes=$_GET['DeliveryPedido'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionList()
	{
		$model=new DeliveryPedido('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DeliveryPedido']))
			$model->attributes=$_GET['DeliveryPedido'];
	
		$this->render('list',array(
				'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DeliveryPedido the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DeliveryPedido::model()->findByPk($id);
		//if($model===null)
		if ( ($model===null) || ( (Yii::app()->user->empresa!=$model->empresa) && (!Yii::app()->user->checkAccess('admin')) ) )
			throw new CHttpException(404,utf8_encode(Yii::t('app', 'appFormLabel5', array(), 'i18n')));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DeliveryPedido $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='delivery-pedido-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
