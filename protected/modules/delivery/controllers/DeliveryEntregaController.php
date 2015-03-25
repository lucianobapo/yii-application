<?php

class DeliveryEntregaController extends Controller
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
				'actions'=>array('create'),
				'roles'=>array('deliveryPedidos'),
			),

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('pagseguro'),
				//'roles'=>array('admin'),
				'users'=>array('@'),
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
	 * @param $id
	 * @throws CHttpException
	 * @throws Exception
     */
	public function actionPagseguro($id)
	{
		if (!Yii::app()->params['pagseguro']) {
			Yii::app()->user->setFlash('erro',Helpers::t('appUi', 'PagSeguro desabilitado.'));
			$this->redirect(array('/'.Helpers::getModuleName()));
			return;
		}
		spl_autoload_unregister(array('YiiBase', 'autoload'));
		require_once(Yii::app()->basePath .'/extensions/pagseguro/PagSeguroLibrary.php');
		spl_autoload_register(array('YiiBase', 'autoload'));
		//Yii::import('application.ext.pagseguro.PagSeguroLibrary');

		if (!empty($_POST)) {
			//https://ws.pagseguro.uol.com.br/v3/transactions/notifications/
			//teste com boleto:
			//47600A2B-7DDA-4D83-8873-92B2D0D4C707?email=luciano.bapo@gmail.com&token=A11120C89C4B4DEA97BBCDDBF930B567
			//teste com cartao:
			//9AB641BB-726A-45FF-8D7B-CC4C108D733D
			//teste com outro user cartao de credito:
			//F5BE60C6-0819-4907-A672-FDBC2FC3C02B
			//teste em produção - boleto:
			//3A2E3E17-1214-4A9C-B309-0FCB5F673D62
			//teste em produção - depósito
			//C529D09A-06E1-4F8D-B7A0-C7A500E0414E

			//v05898056156384143860@sandbox.pagseguro.com.br


			Helpers::gravaArquivoErro(CVarDumper::dumpAsString($_POST));
			try {
				$credentials = PagSeguroConfig::getAccountCredentials();
				$notificationCode = $_POST['notificationCode'];
				$notificationType = $_POST['notificationType'];
			} catch (Exception $e) {
				Helpers::gravaArquivoErro($e->getMessage());
				throw new CHttpException(404,'Erro em notificação de Transação. NOTIFICATIONCODE:' . $_POST['notificationCode']);
			}

			if ($notificationType == 'transaction') {

				try {

					# Objeto Transaction do PagSeguro
					$transaction = PagSeguroNotificationService::checkTransaction($credentials, $notificationCode);

					// Regras de negócio do seu sistema
					Helpers::gravaArquivoErro(CVarDumper::dumpAsString($transaction));
					//echo '<pre>'.CVarDumper::dumpAsString($transaction).'</pre>';

				} catch (PagSeguroServiceException $e) {

					Helpers::gravaArquivoErro($e->getMessage());
					die($e->getMessage());

				}
			}

		}elseif(!empty($id)){
			$erpnet=Yii::app()->getModule('erpnet');

			$modelOrdem=ErpnetOrdem::model()->findByPk($id);
			$modelOrdemItem=ErpnetOrdemItem::model()->findAllByAttributes(array('id_ordem'=>$id));

			//die('aaaaaaaaaa<pre>'.CVarDumper::dumpAsString($modelOrdemItem).'</pre>');

			//Proteção para pedidos inválidos
			if ( ($modelOrdem->status_cancelado==1)||($modelOrdem->status_fechado==1)||($modelOrdem->usuario!=Yii::app()->user->social_identifier) ){
				Yii::app()->user->setFlash('erro',Helpers::t('appUi', 'Erro: Pedido Inválido.'));
				$this->redirect(array('/'.Helpers::getModuleName()));
				return;
			}

			$pagSeguroRequest = new PagSeguroPaymentRequest();

			//die('aaaaaaaaaa<pre>'.CVarDumper::dumpAsString($pagSeguroRequest).'</pre>');

			$pagSeguroRequest->setCurrency("BRL");
			$pagSeguroRequest->setReference($modelOrdem->id);

			$i=1;
			foreach ($modelOrdemItem as $item){
				$produto=ErpnetProduto::model()->findByPk($item->id_produto);
				$pagSeguroRequest->addItem($i, $produto->descricao, $item->quantidade, number_format($produto->valor,2));
				$i=$i+1;
			}

			#####################################################
			// Sets your customer information.
			$cliente=ErpnetCliente::model()->findByPk($modelOrdem->id_cliente);

			$sedexCode = PagSeguroShippingType::getCodeByType('NOT_SPECIFIED');
			$pagSeguroRequest->setShippingType($sedexCode);
			$pagSeguroRequest->setShippingAddress(
				$cliente->cep,
				$cliente->endereco,
				'',//número
				'',//complemento
				'',//bairro
				'Rio das Ostras',
				'RJ',
				'BRA'
			);

			$pagSeguroRequest->setSender(
				$cliente->nome,
				$cliente->email,
				substr($cliente->telefone, 0, 2),
				substr($cliente->telefone, 2, strlen($cliente->telefone)),
				'CPF',
				$cliente->cnpj);

			$pagSeguroRequest->setRedirectUrl("http://".$_SERVER['HTTP_HOST'].$this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryEntrega/create', array("id"=>$id) ));
			// URL para onde serão enviadas notificações (POST) indicando alterações no status da transação
			$pagSeguroRequest->addParameter('notificationURL', 'http://'.$_SERVER['HTTP_HOST'].$this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryEntrega/pagseguro'));

			# Envia pagamento
			try {
				$credentials = PagSeguroConfig::getAccountCredentials();

				// Register this payment request in PagSeguro, to obtain the payment URL for redirect your customer.
				$url = $pagSeguroRequest->register($credentials);

				//echo '<pre>'.CVarDumper::dumpAsString($pagSeguroRequest).'</pre>';
				$this->redirect($url);

			} catch (PagSeguroServiceException $e) {
				Helpers::gravaArquivoErro($e->getMessage());
				die($e->getMessage());
			}
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id=null)
	{
		$erpnet=Yii::app()->getModule('erpnet');
		$model=new DeliveryEntrega;
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

		if(isset($_POST['DeliveryEntrega']))
		{
			$transaction=$model->dbConnection->beginTransaction();
			$model->attributes=$_POST['DeliveryEntrega'];
			$modelOrdem->status_fechado=1;
			if ( ($model->save()) && ($modelOrdem->save()) ) {
				$transaction->commit();

				Yii::trace("Pedido $id confirmado: ".Yii::app()->name.' - '.date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'],'application.delivery');

				$msg='';
				$msg=$msg.'<img width=100 height=100 src="'.$parceiro->custom1."\"><br>\n";
				$msg=$msg.'<h3>'.Helpers::t('appUi', 'Parabéns {nome}! Seu pedido nº{pedido} foi confirmado com sucesso. Segue abaixo os detalhes:',array('{pedido}'=>$id,'{nome}'=>$parceiro->nome))."</h3><br>\n";

				$msg=$msg."<br>\n<b>".Helpers::t('appUi','Endereço de entrega:')."</b><br>\n";
				$msg=$msg.Helpers::t('appUi', "CEP: {cep}",array('{cep}'=>$parceiro->cep))."<br>\n";

				$msg=$msg.Helpers::t('appUi', "Logradouro: {endereco}, {complemento}",array('{endereco}'=>$parceiro->endereco,'{complemento}'=>$parceiro->custom4),'i18n',null,false,true )."<br>\n";
				$msg=$msg.Helpers::t('appUi', "Bairro: {bairro}",array('{bairro}'=>$parceiro->custom3),'i18n',null,false,true)."<br>\n";
				$msg=$msg.Helpers::t('appUi', "Cidade: {cidade}/{uf}",array('{cidade}'=>$parceiro->cidade,'{uf}'=>$parceiro->estado),'i18n',null,false,true)."<br>\n";

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
			Yii::trace("Usuário iniciou a entrega do pedido $id: ".Yii::app()->name.' - '.date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'],'application.delivery.entrega');

			//echo '<pre>'.CVarDumper::dumpAsString($user->email).'</pre>';

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			$this->render('create',array(
				'model'=>$model,'id'=>$id,'parceiro'=>$parceiro,
			));
		}

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

		if(isset($_POST['DeliveryEntrega']))
		{
			$model->attributes=$_POST['DeliveryEntrega'];
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
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DeliveryEntrega('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DeliveryEntrega']))
			$model->attributes=$_GET['DeliveryEntrega'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DeliveryEntrega the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DeliveryEntrega::model()->findByPk($id);
		//if($model===null)
		if ( ($model===null) || ( (Yii::app()->user->empresa!=$model->empresa) && (!Yii::app()->user->checkAccess('admin')) ) )
			throw new CHttpException(404,utf8_encode(Yii::t('app', 'appFormLabel5', array(), 'i18n')));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DeliveryEntrega $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='delivery-entrega-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
