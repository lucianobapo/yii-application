<?php

class ErpnetOrdemController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public $model=null;
	public $modelOrdemItem=null;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			'ajaxOnly + addTabularInputsAsTable',
			'ajaxOnly + addTabularInputsVenda',
			'ajaxOnly + addTabularInputsCompra',
			'ajaxOnly + addTabularInputsServico',
			'ajaxOnly + addTabularInputsConsumo',
			'ajaxOnly + addTabularInputsOrcamentoServico',
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
				'actions'=>array('create','createProducaoMassa','addTabularInputsProducaoMassa'),
				'roles'=>array('erpnetManageOrdem'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create2','updateVenda','createVenda','addTabularInputsVenda'),
				'roles'=>array('erpnetManageOrdemVenda'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('updateCompra','createCompra','addTabularInputsCompra'),
				'roles'=>array('erpnetManageOrdemCompra'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('updateServico','createServico','addTabularInputsServico'),
				'roles'=>array('erpnetCreateOrdemServico'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('updateOrcamentoServico','createOrcamentoServico','addTabularInputsOrcamentoServico'),
				'roles'=>array('erpnetCreateOrcamentoServico'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('createConsumo','addTabularInputsConsumo'),
				'roles'=>array('erpnetCreateOrdemConsumo'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','admin','view','create','update','delete'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * @return array actions
	 */
	public function actions()
	{
		return array(
				'addTabularInputsProducaoMassa'=>array(
						'class'=>'ext.actions.XTabularInputAction',
						'modelName'=>'ErpnetOrdem',
						'scenarioName'=>'producaoMassa',
						'viewName'=>'extensions/_tabularInputProducaoMassa',
				),
				'addTabularInputsVenda'=>array(
						'class'=>'ext.actions.XTabularInputAction',
						'modelName'=>'ErpnetOrdemItem',
						'scenarioName'=>'venda',
						'viewName'=>'extensions/_tabularInputVenda',
				),
				'addTabularInputsCompra'=>array(
						'class'=>'ext.actions.XTabularInputAction',
						'modelName'=>'ErpnetOrdemItem',
						'scenarioName'=>'compra',
						'viewName'=>'extensions/_tabularInputCompra',
				),
				'addTabularInputsServico'=>array(
						'class'=>'ext.actions.XTabularInputAction',
						'modelName'=>'ErpnetOrdemItem',
						'scenarioName'=>'servico',
						'viewName'=>'extensions/_tabularInputServico',
				),
				'addTabularInputsConsumo'=>array(
						'class'=>'ext.actions.XTabularInputAction',
						'modelName'=>'ErpnetOrdemItem',
						'scenarioName'=>'consumo',
						'viewName'=>'extensions/_tabularInputConsumo',
				),
				'addTabularInputsOrcamentoServico'=>array(
						'class'=>'ext.actions.XTabularInputAction',
						'modelName'=>'ErpnetOrdemItem',
						'scenarioName'=>'servico',
						'viewName'=>'extensions/_tabularInputOrcamentoServico',
				),
		);
	}
/*
	public function beforeAction($action) {
		switch ($action->id) {
			case 'createVenda':
				$this->attachBehavior('wizard',array(
					'class'=>'WizardBehavior',
					'steps'=>array('a1s1','a1s2','a1s3'),
					// other wizard configuration
				));
				break;
			default:
				break;
		}
		return parent::beforeAction($action);
	}
	
	public function actionWizard($step=null) {
		$this->process($step);
	}
	
	public function wizardStart($event) {
		$event->handled = true;
	}
	
	public function wizardProcessStep($event) {
		$name = 'process'.ucfirst($event->step);
		if (method_exists($this, $name))
			$event->handled = call_user_func(array($this,$name), $event);
		else
			throw new CException(Yii::t('yii','{class} does not have a method named "{name}".', array('{class}'=>get_class($this), '{name}'=>$name)));
		
		
		$modelName = ucfirst($event->step);
		$model = new $modelName('scenario');
		if ($event->data)
			$model->attributes = $event->data;
		$form = new CForm("path.to.get.{$event->step}.form.configuration", $model);
		if ($form->submitted() && $form->validate()) {
			$event->sender->save($model->attributes);
			$event->handled = true;
		}
		else
			$this->render($event->step, compact('form'));
	}
	
	public function actionRecoverDraft($draftId) {
		$data = Model::model()->recoverDraft($draftId);
		if ($data===false || ! $this->restore($data)){
			// Data recovery failed
		} else
			$this->redirect(array('wizardAction'));
	}
	//*/
	
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
	public function actionCreate2()
	{
		
		$model=ErpnetFatura::model()->findAllByAttributes(array('empresa'=>'marcelo'));
		foreach ($model as $key =>$value) {
			$this->model = ErpnetOrdem::model()->findByPk($value->id_ordem);
			$modelOrdemItem = ErpnetOrdem::model()->findAllByPk($value->id_ordem);
			foreach ($modelOrdemItem as $key2 =>$value2) {
				//*
				echo 'teste';
				$modelFatura = ErpnetFatura::model()->findByPk($value->id);
				//$modelFatura->attributes=$value2->attributes;
				
				if (!$modelFatura->data_movimento=CDateTimeParser::parse($this->model->data_termino, 'yyyy-mm-dd',array('minute'=>0,'hour'=>0,'second'=>0)))
					$modelFatura->data_movimento = $this->model->data_termino;
				
				//if ($modelFatura->save ()) echo 'ok';
				//else echo 'nao';
			}
			/*
			$fatura=new ErpnetFatura();
			$fatura->findByPk($value->id);
			if (!$fatura->data_movimento=CDateTimeParser::parse(ErpnetOrdem::model()->findByPk($value->id_ordem)->data_termino, Yii::app()->locale->dateFormat))
				$fatura->data_movimento=ErpnetOrdem::model()->findByPk($value->id_ordem)->data_termino;
			
			if (!$fatura->save()) echo 'ok';*/
		}
		
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

	}
	
	public function actionCreate()
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['ErpnetOrdem']))
		{
			$model=new ErpnetOrdem;
			$model->setScenario('producao');
			$modelEstoque=new ErpnetEstoque;
			$model->attributes=$_POST['ErpnetOrdem'];
				
			if ($model->save()) {
				$modelEstoque->empresa=$model->empresa;
				$modelEstoque->id_produto=$model->id_produto;
				$modelEstoque->id_ordem=$model->getPrimaryKey();
				$modelEstoque->id_wbs=$model->id_wbs;
				$modelEstoque->descricao_wbs=$model->idWbs->concatened;
				$modelEstoque->data_movimento=date('d/m/Y',strtotime($model->data_termino));
				$modelEstoque->usuario=Yii::app()->user->name;
				$modelEstoque->quantidade=$model->quantidade;
				$modelEstoque->turno=$model->turno;
				$modelEstoque->tipo='entrada';
				if ($modelEstoque->save()) {
					Yii::app()->user->setFlash('ordem',$model->idWbs->concatened.':'.$model->quantidade.' - '.utf8_encode(Yii::t('erpnetUi', 'viewCreateFlash', array(), 'i18n')));
					$this->redirect(array('create'));
				}
			}
		}
	
		$model=new ErpnetOrdem;
		$model->setScenario('producao');
		$modelOrdemItem=new ErpnetOrdemItem;
		$modelOrdemItem->setScenario('producao');
		$modelEstoque=new ErpnetEstoque;
		$modelFatura=new ErpnetFatura;
		$this->render('createOrdem',array(
				'model'=>$model,'modelEstoque'=>$modelEstoque,'modelFatura'=>$modelFatura,'modelOrdemItem'=>$modelOrdemItem,
				'tipo'=>'producaoUnica',
		));
	}
	
	public function actionCreateProducaoMassa()
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['ErpnetOrdem']))
		{
			$sucesso='';
			
			for ($i=0;$i<count($_POST['ErpnetOrdem']);$i++) 
				if ( (isset($_POST['ErpnetOrdem'][$i]))&&($_POST['ErpnetOrdem'][$i]['quantidade']>0) ) {
					$this->model=new ErpnetOrdem;
					$this->model->setScenario('producaoMassa');
					$transaction=$this->model->dbConnection->beginTransaction();
					
					$this->model->attributes=$_POST['ErpnetOrdem'][$i];
					$this->model->data_termino=CDateTimeParser::parse($this->model->data_termino, Yii::app()->locale->dateFormat);
					$this->model->id_produto=$_POST['ErpnetOrdem']['id_produto'];
					$this->model->turno=$_POST['ErpnetOrdem']['turno'];
					$desc=explode(':', $_POST['ErpnetOrdem']['id_wbs']);
					$this->model->id_wbs=ErpnetWbs::model()->findByPk($desc[0])->id;
				
					if ( ($transaction->getActive())&&(!$this->model->save()) ) {
						$transaction->rollback();
						Yii::app()->user->setFlash('erro',Helpers::t('erpnetUi', 'model'));
						$this->redirect(array('createProducaoMassa'));
					}
					// Cria movimento de estoque
					//$this->modelOrdemItem=$this->model;
					$this->model->data_termino=Yii::app()->dateFormatter->formatDateTime($this->model->data_termino,'medium',null);
					if ( ($transaction->getActive())&&(!$this->cadastraEstoque($this->model,'entrada')) ) {
						$transaction->rollback();
						Yii::app()->user->setFlash('erro',Helpers::t('erpnetUi', 'modelEstoque'));
						$this->redirect(array('createProducaoMassa'));
					}
						
					if ($transaction->getActive()){
						$sucesso=$sucesso.Yii::app()->dateFormatter->formatDateTime($this->model->data_termino,'medium',null).' - '.$this->model->idWbs->concatened.': '.$this->model->quantidade.'<br>';
						$transaction->commit();
					}
				}
			
			if ($sucesso!='') Yii::app()->user->setFlash('ordem',$sucesso.' <br> '.Helpers::t('erpnetUi', 'viewCreateFlash'));
			$this->redirect(array('createProducaoMassa'));
		}
		
		
		$model=new ErpnetOrdem;
		$model->setScenario('producaoMassa');
		$modelEstoque=new ErpnetEstoque;
		
		$models=array();
		for($i = strtotime("-1 month",mktime(null,null,null,date('m'),1,date('Y'))); date ( 'm', $i ) == date ( 'm',strtotime("-1 month") ); $i = strtotime ( "+1 day", $i ))
			array_push ( $models, $model );
		
		$tabular=array(
				'models'=>$models,
				'containerTagName'=>'table',
				'headerTagName'=>'thead',
				'inputContainerTagName'=>'tbody',
				'inputTagName'=>'tr',
				//'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
				//'addLabel'=>Yii::t('ui','Adicionar novo item'),
				//'addHtmlOptions'=>array('class'=>'blue pill'),
				'removeTemplate'=>'',
				//'removeTemplate'=>'<td>{link}</td>',
				//'removeLabel'=>Yii::t('ui','Retirar'),
				'removeLabel'=>'',
				'addLabel'=>'',
				//'removeHtmlOptions'=>array('class'=>'red pill'),
		);
		
		$tabular['inputView']='extensions/_tabularInputProducaoMassa';
		$tabular['inputUrl']=$this->createUrl('addTabularInputsProducaoMassa');
		$tabular['header']='<tr><td>'.
			CHtml::activeLabelEX($model,'data_termino',array('class'=>'input-medium')).'</td><td>'.
			//CHtml::activeLabelEX($model,'id_produto',array('class'=>'input-medium')).'</td><td>'.
			//CHtml::activeLabelEX($model,'id_wbs',array('class'=>'input-large')).'</td><td>'.
			//CHtml::activeLabelEX($model,'turno',array('class'=>'input-small')).'</td><td>'.
			CHtml::activeLabelEX($model,'quantidade',array('class'=>'input-small')).'</td>'.
			'</tr>';
		
		
		$this->render('createOrdemServico',array(
				'model'=>$model,
				'modelEstoque'=>$modelEstoque,
				//'modelFatura'=>$modelFatura,
				//'modelPagar'=>$modelPagar,
				//'modelOrdemItem'=>$modelOrdemItem,
				'tabular'=>$tabular,
				'fileForm'=>'_formProducaoMassa',
				'fileFormHeader'=>'_formProducaoMassaHeader',
		));
	}

	public function actionCreateConsumo()
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['ErpnetOrdem']))
		{
			$model=new ErpnetOrdem;
			$model->setScenario('consumo');
			$model->attributes=$_POST['ErpnetOrdem'];
			$desc=explode(':', $_POST['ErpnetOrdem']['id_wbs_destino']);
			$model->id_wbs_destino=$desc[0];
			$transaction=$model->dbConnection->beginTransaction();
	
			if ( (isset($_POST['ErpnetOrdemItem']))&&($model->save()) ) {
				$sucesso='';
				$valor=0;
				for ($i=0;$i<count($_POST['ErpnetOrdemItem']);$i++) {
					$modelOrdemItem=new ErpnetOrdemItem;
					$modelOrdemItem->setScenario('consumo');
					$modelOrdemItem->attributes=$_POST['ErpnetOrdemItem'][$i];
					$modelOrdemItem->id_ordem=$model->getPrimaryKey();
					$modelOrdemItem->data_termino=$model->data_termino;
					$valor=$valor+($modelOrdemItem->valor*Helpers::getQuote(time(),$modelOrdemItem->moeda)*$modelOrdemItem->quantidade);
						
					if ($modelOrdemItem->save()) {
						// Pega dados do produto
						$modelProduto=ErpnetProduto::model()->findByPk($modelOrdemItem->id_produto);
	
						
						$modelEstoque=new ErpnetEstoque;
						// Cria movimento de estoque
						$modelEstoque->id_produto=$modelOrdemItem->id_produto;
						if ($modelOrdemItem->quantidade>0) $modelEstoque->quantidade=$modelOrdemItem->quantidade*(-1);
						else $modelEstoque->quantidade=$modelOrdemItem->quantidade;
						
						$modelEstoque->id_ordem=$model->getPrimaryKey();
						//$modelEstoque->id_ordem_item=$modelOrdemItem->getPrimaryKey();
						$modelEstoque->id_wbs=$model->id_wbs;
						$modelEstoque->descricao_wbs=$model->idWbs->concatened;
						$modelEstoque->data_movimento=date('d/m/Y',strtotime($model->data_termino));
						
						$modelEstoque->empresa=Yii::app()->user->empresa;
						$modelEstoque->usuario=Yii::app()->user->name;
						$modelEstoque->tipo='saida';
						
						//*
						// Cria movimento de faturamento
						$modelFatura=new ErpnetFatura;
						$modelFatura->id_produto=$modelOrdemItem->id_produto;
						if ($modelOrdemItem->quantidade<0) $modelFatura->quantidade=$modelOrdemItem->quantidade*(-1);
						else $modelFatura->quantidade=$modelOrdemItem->quantidade;
	
						$modelFatura->id_ordem=$model->getPrimaryKey();
						$modelFatura->id_wbs=$model->id_wbs_destino;
						//$modelFatura->descricao_wbs=$model->idWbs->concatened;
						$modelFatura->data_movimento=date('d/m/Y',strtotime($model->data_termino));
	
						$modelFatura->empresa=Yii::app()->user->empresa;
						$modelFatura->usuario=Yii::app()->user->name;
						$modelFatura->tipo='entrada';
						
	
						// Pega o valor e moeda do cadastro do produto
						if ($modelOrdemItem->valor==0) {
							$modelFatura->valor=$modelProduto->valor;
							$modelFatura->moeda=$modelProduto->moeda;
						} else {
							$modelFatura->valor=$modelOrdemItem->valor;
							$modelFatura->moeda=$modelOrdemItem->moeda;
						}
	
						if ( ($modelFatura->save())&&($modelEstoque->save()) ) {
							$sucesso=$sucesso.$modelOrdemItem->idProduto->concatened.': '.$modelOrdemItem->quantidade.'<br>';
						} else {
							//$transactionOrdemItem->rollback();
							Yii::app()->user->setFlash('erro',utf8_encode(Yii::t('erpnetUi', '1viewCreateFlash', array(), 'i18n')));
						}
						//*/
					} else {
						//$transactionOrdemItem->rollback();
						Yii::app()->user->setFlash('erro',utf8_encode(Yii::t('erpnetUi', '2viewCreateFlash', array(), 'i18n')));
					}
				}
	
				$model->valor=$valor;
				$model->data_termino=date('d/m/Y',strtotime($model->data_termino));
				$model->save();
	
				if ($sucesso=='') {
					$transaction->rollback();
					//Yii::app()->user->setFlash('erro',utf8_encode(Yii::t('erpnetUi', '3viewCreateFlash', array(), 'i18n')));
				} else {
					$transaction->commit();
					Yii::app()->user->setFlash('ordem',$sucesso.' <br> '.utf8_encode(Yii::t('erpnetUi', 'viewCreateFlash', array(), 'i18n')));
				}
				if(Yii::app()->user->hasFlash('ordem')) $this->redirect(array('createConsumo'));
			}
		}
	
		$model=new ErpnetOrdem;
		$model->setScenario('consumo');
		$modelOrdemItem=new ErpnetOrdemItem;
		$modelOrdemItem->setScenario('consumo');
		$modelEstoque=new ErpnetEstoque;
		$modelFatura=new ErpnetFatura;
	
		$tabular=array(
				'models'=>array($modelOrdemItem),
				'containerTagName'=>'table',
				'headerTagName'=>'thead',
				'inputContainerTagName'=>'tbody',
				'inputTagName'=>'tr',
				'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
				'addLabel'=>Yii::t('ui','Adicionar novo item'),
				'addHtmlOptions'=>array('class'=>'blue pill'),
				'removeTemplate'=>'<td>{link}</td>',
				'removeLabel'=>Yii::t('ui','Retirar'),
				'removeHtmlOptions'=>array('class'=>'red pill'),
		);
	
		$tabular['inputView']='extensions/_tabularInputConsumo';
		$tabular['inputUrl']=$this->createUrl('addTabularInputsConsumo');
		$tabular['header']='<tr><td>'.
				CHtml::activeLabelEX($modelOrdemItem,'id_produto',array('class'=>'input-xlarge')).'</td><td>'.
				//CHtml::activeLabelEX(ErpnetOrdemItem::model(),'data_entrega',array('class'=>'input-small')).'</td><td>'.
		CHtml::activeLabelEX($modelOrdemItem,'quantidade',array('class'=>'input-small')).'</td><td>'.
		CHtml::activeLabelEX($modelOrdemItem,'valor',array('class'=>'input-small')).'</td><td>'.
		CHtml::activeLabelEX($modelOrdemItem,'moeda',array('class'=>'input-small')).'</td>'.
		'</tr>';
	
		$this->render('createOrdemServico',array(
				'model'=>$model,
				'modelEstoque'=>$modelEstoque,
				'modelFatura'=>$modelFatura,
				'modelOrdemItem'=>$modelOrdemItem,
				'tabular'=>$tabular,
				'fileForm'=>'_formConsumo',
				'fileFormHeader'=>'_formConsumoHeader',
		));
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

		if(isset($_POST['ErpnetOrdem']))
		{
			$model->attributes=$_POST['ErpnetOrdem'];
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
		$model=new ErpnetOrdem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ErpnetOrdem']))
			$model->attributes=$_GET['ErpnetOrdem'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ErpnetOrdem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ErpnetOrdem::model()->findByPk($id);
		//if($model===null)
		if ( ($model===null) || ( (Yii::app()->user->empresa!=$model->empresa) && (!Yii::app()->user->checkAccess('admin')) ) )
			throw new CHttpException(404,utf8_encode(Yii::t('app', 'appFormLabel5', array(), 'i18n')));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ErpnetOrdem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='erpnet-ordem-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function getColuna(){
		//*
		$tipo = null;
		$title="Ordens em Aberto:";
		if ( ($this->action->id == 'createVenda')||($this->action->id == 'updateVenda') ) {
			$tipo = 'venda';
			$actionUpdate='updateVenda';
		} elseif ( ($this->action->id == 'createCompra')||($this->action->id == 'updateCompra') ) {
			$tipo = 'compra';
			$actionUpdate='updateCompra';
		} elseif ( ($this->action->id == 'createServico')||($this->action->id == 'updateServico') ) {
			$tipo = 'servico';
			$actionUpdate='updateServico';
		} elseif ( ($this->action->id == 'createOrcamentoServico')||($this->action->id == 'updateOrcamentoServico') ) {
			$tipo = 'orcamentoServico';
			$actionUpdate='updateOrcamentoServico';
			$title=utf8_encode("Or�amentos em Aberto:");
		}
		if ($tipo!= null) {
			$models = ErpnetOrdem::model ()->findAllByAttributes ( array (
					'tipo' => $tipo,
					'status_fechado' => 0,
					'empresa' => Yii::app ()->user->empresa
			) );
			$itens = array ();
			foreach ( $models as $key => $model ) 
				array_push ( $itens, $model );
			$gridDataProvider = new CArrayDataProvider ( $itens );
			$gridDataProvider->setPagination(false);
			$this->renderPartial('coluna',array(
					'gridDataProvider'=>$gridDataProvider,
					'actionUpdate'=>$actionUpdate,
					'title'=>$title,
			));
		}
		//*/
	}
	
	private function createOrdem($action,$scenario,$redirectCreateAction,$redirectUpdateAction,$fileFormHeader,$fileForm,$tabularAction,$tabularInput) {
		$this->preparaOrdem($action,$redirectCreateAction,$scenario);
		$models=array();
		$this->preparaOrdemItem($action,$scenario,$models);
		if(isset($_POST['ErpnetOrdem'])) {
			$transaction=$this->model->dbConnection->beginTransaction();
			$this->gravaOrdem($scenario,$transaction);
			if (isset($_POST['ErpnetOrdemItem'])) {
				$sucesso='';
				$valor=0;
				$nao_apagar=null;
				foreach ($_POST['ErpnetOrdemItem'] as $i => $value)
				if ( (isset($_POST['ErpnetOrdemItem'][$i])) && ($_POST['ErpnetOrdemItem'][$i]['id_produto']!='') ){
					$this->modelOrdemItem[$i]=new ErpnetOrdemItem($scenario);
					$this->modelOrdemItem[$i]->attributes=$_POST['ErpnetOrdemItem'][$i];
					$this->modelOrdemItem[$i]->id_ordem=$this->model->getPrimaryKey();
					//$this->modelOrdemItem[$i]->data_termino=$this->model->data_termino;
					
					$this->modelOrdemItem[$i]->data_termino=CDateTimeParser::parse($this->model->data_termino, Yii::app()->locale->dateFormat);
					
					if ($scenario=='compra')
						$this->modelOrdemItem[$i]->data_entrega=CDateTimeParser::parse($this->modelOrdemItem[$i]->data_entrega, Yii::app()->locale->dateFormat);
		
					$this->performAjaxValidation($this->modelOrdemItem[$i]);
					$this->gravaOrdemItem($scenario,$transaction,$i,$valor,$nao_apagar,$sucesso);
				}
				$this->finalizaOrdem(Helpers::t('erpnetUi', 'viewCreateFlash'),$redirectCreateAction,$redirectUpdateAction,$transaction,$valor,$sucesso,($scenario=='venda'));
			}
		}
		$this->renderizaOrdem($fileFormHeader,$fileForm,$tabularAction,$tabularInput,$scenario,$models,false);
	}
	
	private function updateOrdem($action,$scenario,$redirectCreateAction,$redirectUpdateAction,$fileFormHeader,$fileForm,$tabularAction,$tabularInput,$id) {
		$this->preparaOrdem($action,$redirectCreateAction,$scenario,$id);
		$models=array();
		$this->preparaOrdemItem($action,$scenario,$models,$id);
		if(isset($_POST['ErpnetOrdem'])) {
			$transaction=$this->model->dbConnection->beginTransaction();
			$this->gravaOrdem($scenario,$transaction);
			if (isset($_POST['ErpnetOrdemItem'])) {
				$sucesso='';
				$valor=0;
				$nao_apagar=null;
				foreach ($_POST['ErpnetOrdemItem'] as $i => $value)
				if ( (isset($_POST['ErpnetOrdemItem'][$i])) && ($_POST['ErpnetOrdemItem'][$i]['id_produto']!='') ){
					$this->modelOrdemItem[$i]=new ErpnetOrdemItem($scenario);
					$this->modelOrdemItem[$i]->attributes=$_POST['ErpnetOrdemItem'][$i];
					$this->modelOrdemItem[$i]->id_ordem=$this->model->getPrimaryKey();
					$this->modelOrdemItem[$i]->data_termino=$this->model->data_termino;
					
					if ( (isset($_POST['ErpnetOrdemItem'][$i]['id']))&&($_POST['ErpnetOrdemItem'][$i]['id']!='') ) {
						$this->modelOrdemItem[$i]=ErpnetOrdemItem::model()->findByPk($_POST['ErpnetOrdemItem'][$i]['id']);
						$this->modelOrdemItem[$i]->setScenario($scenario);
						$this->modelOrdemItem[$i]->attributes=$_POST['ErpnetOrdemItem'][$i];
						$nao_apagar[$_POST['ErpnetOrdemItem'][$i]['id']]=true;
					}
					$this->performAjaxValidation($this->modelOrdemItem[$i]);
					$this->gravaOrdemItem($scenario,$transaction,$i,$valor,$nao_apagar,$sucesso);
				}
				if ($transaction->getActive()) $this->apagaItens($nao_apagar);
				$this->finalizaOrdem(Helpers::t('erpnetUi', 'viewUpdateFlash'),$redirectCreateAction,$redirectUpdateAction,$transaction,$valor,$sucesso,false);
			}
		}
		$this->renderizaOrdem($fileFormHeader,$fileForm,$tabularAction,$tabularInput,$scenario,$models,true);
	}
	
	public function gravaOrdem($scenario,&$transaction) {
		$this->model->attributes=$_POST['ErpnetOrdem'];
			
		//transforma cliente em id, se n�o achar cadastra cliente
		if ( ($scenario=='venda')&&(ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->search_cliente_venda)
			&& ( ($this->model->id_cliente=ErpnetCliente::getIdSearch($_POST['ErpnetOrdem']['id_cliente']) )==null )
			&& (!$this->model->id_cliente=$this->cadastraCliente()) ) {
				$transaction->rollback();
				$this->model->addError('id_cliente', Helpers::t('erpnetUi', 'Não foi possível cadastrar este cliente. Verifique os dados.'));
				Helpers::registraErro($this->model->getErrors());
			}
		
		if ( ($transaction->getActive())&&(!$this->model->save()) ) $transaction->rollback();
	}
	
	private function renderizaOrdem($fileFormHeader,$fileForm,$tabularAction,$tabularInput,$scenario,$models,$mostraRetirar) {
		$tabular=array(
				'models'=>$models,
				'containerTagName'=>'table',
				'headerTagName'=>'thead',
				'inputContainerTagName'=>'tbody',
				'inputTagName'=>'tr',
				'addTemplate'=>'<tbody><tr><td colspan="3" align=right>{link}</td></tr></tbody>',
				'addLabel'=>Yii::t('ui','Adicionar novo item'),
				'addHtmlOptions'=>array('class'=>'blue pill'),
		);
		if ($mostraRetirar) {
			$tabular['removeTemplate']='<td>{link}</td>';
			$tabular['removeLabel']=Yii::t('ui','Retirar');
			$tabular['removeHtmlOptions']=array('class'=>'red pill');
		} else $tabular['removeLabel']='';
		
		$modelOrdemItem=new ErpnetOrdemItem($scenario);
		$tabular['inputView']='extensions/'.$tabularInput;
		$tabular['inputUrl']=$this->createUrl($tabularAction);
		
		$tabular['header']='<tr>'.
			'<td>'.CHtml::activeLabelEX($modelOrdemItem,'id_produto',array('class'=>'input-xlarge')).'</td>';
		
		if ($scenario=='compra') $tabular['header']=$tabular['header'].
			'<td>'.CHtml::activeLabelEX($modelOrdemItem,'data_entrega',array('class'=>'input-medium')).'</td>';
				
		$tabular['header']=$tabular['header'].
			'<td>'.CHtml::activeLabelEX($modelOrdemItem,'quantidade',array('class'=>'input-small')).'</td>'.
			'<td>'.CHtml::activeLabelEX($modelOrdemItem,'valor',array('class'=>'input-small')).'</td>';
			
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->outras_moedas) $tabular['header']=$tabular['header'].
			'<td>'.CHtml::activeLabelEX($modelOrdemItem,'moeda',array('class'=>'input-medium')).'</td>';
		
		$tabular['header']=$tabular['header'].'</tr>';
		
		$this->render('createOrdemServico',array(
				'model'=>$this->model,
				'modelOrdemItem2'=>$this->modelOrdemItem,
				'tabular'=>$tabular,
				'fileForm'=>$fileForm,
				'fileFormHeader'=>$fileFormHeader,
		));
	}
	
	public function preparaOrdem($acao,$redirectAction,$scenario,$id=null) {
		if ($acao=='create') {
			$this->model=new ErpnetOrdem($scenario);
		}elseif ($acao=='update' ){
			$this->model=ErpnetOrdem::model()->findByPk($id);
			if ($this->model->status_fechado) $this->redirect(array($redirectAction));
			$this->model->setScenario($scenario);
			$this->model->data_termino=Yii::app()->dateFormatter->formatDateTime($this->model->data_termino,'medium',null);
				
			//transforma ID em cliente
			if ( ($scenario=='venda')&&(ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->search_cliente_venda) )
				$this->model->id_cliente=ErpnetCliente::model()->findByPk($this->model->id_cliente)->nome;
		}
		$this->performAjaxValidation($this->model);
	}
	
	public function preparaOrdemItem($acao,$scenario,&$models,$id=null) {
		if ($acao=='create'){
			for ($i=0;$i<4;$i++) {
				$this->modelOrdemItem[$i]=new ErpnetOrdemItem($scenario);
				$this->performAjaxValidation($this->modelOrdemItem[$i]);
				array_push( $models, $this->modelOrdemItem[$i] );
			}
		}elseif ($acao=='update' ){
			foreach (ErpnetOrdemItem::model()->findAllByAttributes(array('id_ordem'=>$id)) as $key => $value ) {
				$this->modelOrdemItem[$key]=$value;
				
				//transforma ID em produto
				if ( ($scenario=='venda')&&(ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->search_produto_venda) )
					$this->modelOrdemItem[$key]->id_produto=ErpnetProduto::model()->findByPk($this->modelOrdemItem[$key]->id_produto)->descricao;
				
				//transforma data
				if ($scenario=='compra')
					$this->modelOrdemItem[$key]->data_entrega=Yii::app()->dateFormatter->formatDateTime($this->modelOrdemItem[$key]->data_entrega,'medium',null);
				
				if (strpos($this->modelOrdemItem[$key]->valor, '.'))
					$this->modelOrdemItem[$key]->valor = str_replace('.', ',', $this->modelOrdemItem[$key]->valor);
				
				$this->performAjaxValidation($this->modelOrdemItem[$key]);
				
				$this->modelOrdemItem[$key]->setScenario($scenario);
				array_push( $models, $this->modelOrdemItem[$key] );
			}
		}
	}
	
	public function finalizaOrdem($msg,$redirectCreateAction,$redirectUpdateAction,&$transaction,$valor,$sucesso,$transformaProdutos,$redirectUpdateController='erpnetOrdem') {
		if ($transaction->getActive()) {
			if (empty($this->model->desconto))
				$this->model->valor=$valor;
			else
				$this->model->valor=$valor-$this->model->desconto;
			//$this->model->data_termino=Yii::app()->dateFormatter->formatDateTime($this->model->data_termino,'medium',null);
			$this->model->data_termino=CDateTimeParser::parse($this->model->data_termino, Yii::app()->locale->dateFormat);
			if (!$this->model->save()) $transaction->rollback();
		}
		
		if ( ($sucesso!='')&&($transaction->getActive()) ) {
			$transaction->commit();
			Yii::app()->user->setFlash('ordem',$sucesso.$msg.' - '.Yii::app()->dateFormatter->formatDateTime(time()));
			if ($this->model->status_fechado) 
				$this->redirect(array($redirectCreateAction));
			else
				$this->redirect(Yii::app()->createUrl(Helpers::getModuleName()."/$redirectUpdateController/".$redirectUpdateAction, array("id"=>$this->model->id)));
		} elseif ($transaction->getActive()) {
			$transaction->rollback();
			$this->modelOrdemItem[0]->addError('id_produto', 'Verifique o Preenchimento dos produtos');
			Helpers::registraErro($this->modelOrdemItem[0]->getErrors());
		}
		
		if (!$transaction->getActive()) {
			//transforma a data em formato leg�vel
			$this->model->data_termino=Yii::app()->dateFormatter->formatDateTime($this->model->data_termino,'medium',null);
			
			//transforma id em cliente, se não achar permanece o que foi digitado
			if ( (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->search_cliente_venda)
				&& ( ($this->model->id_cliente=ErpnetCliente::model()->findByPk($this->model->id_cliente)->nome )==null ) )
					$this->model->id_cliente=$_POST['ErpnetOrdem']['id_cliente'];
			
			if ($transformaProdutos)
				foreach ($_POST['ErpnetOrdemItem'] as $i => $value) {
					//transforma ID em produto, se n�o achar permanece o que foi digitado
					if ( (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->search_produto_venda)
						&& ($i<4)
						&& (isset($_POST['ErpnetOrdemItem'][$i]))
						&& ($_POST['ErpnetOrdemItem'][$i]['id_produto']!='')
						&& ($aux=$this->modelOrdemItem[$i]->id_produto)
						&& ( ($this->modelOrdemItem[$i]->id_produto=ErpnetProduto::model()->findByPk($aux)->descricao)==null) )
							$this->modelOrdemItem[$i]->id_produto=$aux;
			}
		}
	}
	
	public function gravaOrdemItem($scenario,&$transaction,$i,&$valor,&$nao_apagar,&$sucesso) {
		
		//transforma produto em ID, se n�o achar permanece o que foi digitado
		if ( ($scenario=='venda')&&(ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->search_produto_venda)
			&& ( ($this->modelOrdemItem[$i]->id_produto=ErpnetProduto::getIdSearch($this->modelOrdemItem[$i]->id_produto))==null) )
				$this->modelOrdemItem[$i]->id_produto=$_POST['ErpnetOrdemItem'][$i]['id_produto'];
		
		$this->somaValores($this->modelOrdemItem[$i],$valor);
		
		if ( ($transaction->getActive())&&(!$this->modelOrdemItem[$i]->save()) ) $transaction->rollback();
		
		$this->movimentosSubsequentes($scenario,$transaction,$i);
		
		$nao_apagar[$this->modelOrdemItem[$i]->getPrimaryKey()]=true;
		if ($transaction->getActive())
			$sucesso=$sucesso.$this->modelOrdemItem[$i]->idProduto->concatened.': '.$this->modelOrdemItem[$i]->quantidade.'<br>';
	}
	
	private function movimentosSubsequentes($scenario,&$transaction,$i) {
		if ( ($this->model->status_fechado)&&($transaction->getActive()) ) {
			if ($scenario!='servico')
				// Cria movimento de estoque
				if (!$this->cadastraEstoque($this->modelOrdemItem[$i],($scenario=='compra' ? 'entrada' : 'saida'),$erro)) {
					$this->modelOrdemItem[$i]->addError('id_produto', 'Erro ao Processar o Estoque');
					if (defined('YII_DEBUG')) $this->modelOrdemItem[$i]->addError('id_produto', 'Detalhe do Erro:'.'<pre>'.CVarDumper::dumpAsString($this->modelOrdemItem[$i]).'</pre>'.'<pre>'.CVarDumper::dumpAsString($erro).'</pre>');
					Helpers::registraErro($this->modelOrdemItem[$i]->getErrors());
					if ($transaction->getActive()) $transaction->rollback();
				}
			if ($scenario!='compra')
				// Cria movimento de faturamento
				if (!$this->cadastraContasReceber($this->modelOrdemItem[$i])) {
					$this->modelOrdemItem[$i]->addError('id_produto', 'Erro ao Processar Contas a Receber');
					Helpers::registraErro($this->modelOrdemItem[$i]->getErrors());
					if ($transaction->getActive()) $transaction->rollback();
				}
			
				
			if ($scenario=='compra')
				// Cria movimento de contas pagar
				if (!$this->cadastraContasPagar($this->modelOrdemItem[$i],$erroContasPagar)) {
					$this->modelOrdemItem[$i]->addError('id_produto', 'Erro ao Processar Contas a Pagar');
					if (defined('YII_DEBUG')) $this->modelOrdemItem[$i]->addError('id_produto', 'Detalhe do Erro:'.'<pre>'.CVarDumper::dumpAsString($this->modelOrdemItem[$i]).'</pre>'.'<pre>'.CVarDumper::dumpAsString($erroContasPagar).'</pre>');
					Helpers::registraErro($this->modelOrdemItem[$i]->getErrors());
					if ($transaction->getActive()) $transaction->rollback();
				}
				
		}
	}
	
	private function cadastraCliente() {
		if ( (!isset($_POST['ErpnetOrdem']['id_cliente'])) 
			|| (!isset($_POST['ErpnetCliente']['endereco'])) )
			//|| ($_POST['ErpnetCliente']['endereco']=='') )
		return false;
		
		$model= new ErpnetCliente;
		$model->nome=$_POST['ErpnetOrdem']['id_cliente'];
		$model->endereco=$_POST['ErpnetCliente']['endereco'];
		$model->tipo_cliente=1;
		$model->empresa=Yii::app()->user->empresa;
		if (!$model->save()) return false;
		return $model->getPrimaryKey();
	}
	
	private function cadastraEstoque($item=null,$tipo='saida',&$erro=null) {
		if ( ($this->model===null)||($item===null) ) return false;
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->movimenta_estoque) {
			// Cria movimento de estoque
			$modelEstoque=new ErpnetEstoque;
			$modelEstoque->id_produto=$item->id_produto;
			if ( ($item->quantidade>0)&&($tipo=='saida') ) 
				$modelEstoque->quantidade=$item->quantidade*(-1);
			elseif ( ($item->quantidade<0)&&($tipo=='entrada') ) 
				$modelEstoque->quantidade=$item->quantidade*(-1);
			else $modelEstoque->quantidade=$item->quantidade;
	
			//if (isset($item->id_ordem))
			//	$modelEstoque->id_ordem=$item->id_ordem;
			//else 
			
			$modelEstoque->id_ordem=$this->model->id;
			
			$modelEstoque->id_wbs=$this->model->id_wbs;
			$modelEstoque->turno=$this->model->turno;
			
			//$modelEstoque->data_movimento=$item->data_termino;
			if (CDateTimeParser::parse($item->data_termino, Yii::app()->locale->dateFormat))
				$modelEstoque->data_movimento=CDateTimeParser::parse($item->data_termino, Yii::app()->locale->dateFormat);
			else 
				$modelEstoque->data_movimento=$item->data_termino;
	
			$modelEstoque->empresa=Yii::app()->user->empresa;
			$modelEstoque->usuario=Yii::app()->user->name;
			$modelEstoque->tipo=$tipo;
			$erro=$modelEstoque;
			return $modelEstoque->save();
		} else return true;
	}
	
	private function cadastraContasReceber($item=null) {
		if (($this->model === null) || ($item === null))
			return false;
		if (ErpnetConfig::model ()->findByPk ( Yii::app ()->user->empresa )->movimenta_conta_receber) {
			// Cria movimento de faturamento
			$modelFatura = new ErpnetFatura ();
			$modelFatura->id_produto = $item->id_produto;
			if ($item->quantidade < 0)
				$modelFatura->quantidade = $item->quantidade * (- 1);
			else
				$modelFatura->quantidade = $item->quantidade;
				
			$modelFatura->id_ordem = $this->model->id;
			
			
			$modelFatura->id_wbs = $this->model->id_wbs;
			//$modelFatura->data_movimento = $item->data_termino;
			//$modelFatura->data_movimento=CDateTimeParser::parse($item->data_termino, Yii::app()->locale->dateFormat);
			
			if (CDateTimeParser::parse($item->data_termino, Yii::app()->locale->dateFormat))
				$modelFatura->data_movimento=CDateTimeParser::parse($item->data_termino, Yii::app()->locale->dateFormat);
			else
				$modelFatura->data_movimento=$item->data_termino;
				
			$modelFatura->empresa = Yii::app ()->user->empresa;
			$modelFatura->usuario = Yii::app ()->user->name;
			$modelFatura->tipo = 'entrada';
				
			// Pega o valor e moeda do cadastro do produto
			// Pega dados do produto
			$modelProduto = ErpnetProduto::model ()->findByPk ( $item->id_produto );
			if ($item->valor == 0) {
				$modelFatura->valor = $modelProduto->valor;
				$modelFatura->moeda = $modelProduto->moeda;
			} else {
				$modelFatura->valor = $item->valor;
				$modelFatura->moeda = $item->moeda;
			}
			return $modelFatura->save ();
		} else
			return true;
	}
	
	private function cadastraContasPagar($item=null,&$erro=null) {
		if (($this->model === null) || ($item === null)) {
			$erro='erro no item';
			return false;
		}
		if (ErpnetConfig::model ()->findByPk ( Yii::app ()->user->empresa )->movimenta_conta_pagar) {
			// Cria movimento de contas pagar
			$modelPagar = new ErpnetPagar;
			$modelPagar->id_produto = $item->id_produto;
			if ($item->quantidade < 0)
				$modelPagar->quantidade = $item->quantidade * (- 1);
			else
				$modelPagar->quantidade = $item->quantidade;
	
			$modelPagar->id_ordem = $this->model->id;
			
			$modelPagar->id_parceiro = $this->model->id_cliente;
			$modelPagar->id_wbs = $this->model->id_wbs;
			
			if (CDateTimeParser::parse($item->data_termino, Yii::app()->locale->dateFormat))
				$modelPagar->data_movimento=CDateTimeParser::parse($item->data_termino, Yii::app()->locale->dateFormat);
			else
				$modelPagar->data_movimento=$item->data_termino;
			
			//$modelPagar->data_movimento = CDateTimeParser::parse($item->data_termino, Yii::app()->locale->dateFormat);
	
			$modelPagar->empresa = Yii::app ()->user->empresa;
			$modelPagar->usuario = Yii::app ()->user->name;
			$modelPagar->tipo = 'entrada';
	
			// Pega o valor e moeda do cadastro do produto
			// Pega dados do produto
			$modelProduto = ErpnetProduto::model ()->findByPk ( $item->id_produto );
			if ($item->valor == 0) {
				$modelPagar->valor = $modelProduto->valor;
				$modelPagar->moeda = $modelProduto->moeda;
			} else {
				$modelPagar->valor = $item->valor;
				$modelPagar->moeda = $item->moeda;
			}
			$erro=$modelPagar;
			return $modelPagar->save ();
		} else
			return true;
	}
	
	public function apagaItens($nao_apagar) {
		//if ($nao_apagar===null) return true;
		if (($this->model !== null) && ($nao_apagar !== null)) {
			$modelOrdemItem=ErpnetOrdemItem::model()->findAllByAttributes(array('id_ordem'=>$this->model->getPrimaryKey()));
			foreach ($modelOrdemItem as $key=>$value)
			if (!array_key_exists($value->id, $nao_apagar)) ErpnetOrdemItem::model()->findByPk($value->id)->delete();
		}
	}
	
	private function somaValores(&$item=null,&$valor=null) {
		if ( ($item===null)||($valor === null) )
			return false;
		
		if (!$item->valor > 0) {
			// Pega dados do produto
			$modelProduto = ErpnetProduto::model ()->findByPk ( $item->id_produto );
			$item->valor = $modelProduto->valor;
			$item->moeda = $modelProduto->moeda;
		}
		
		if (strpos($item->valor, ','))
			$item->valor = str_replace(',', '.', $item->valor);
		
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->outras_moedas)
			$valor=$valor+($item->valor*Helpers::getQuote(time(),$item->moeda)*$item->quantidade);
		else
			$valor=$valor+($item->valor * $item->quantidade);
		
		if (strpos($item->valor, '.'))
			$item->valor = str_replace('.', ',', $item->valor);
	}
	
	public function actionCreateVenda()
	{
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->mostra_vendas) $this->layout='//layouts/column3';
		
		$this->createOrdem('create', 'venda', 'createVenda', 'updateVenda', 
				'_formVendaHeader', '_formVenda', 'addTabularInputsVenda', '_tabularInputVenda');
		
	}
	
	public function actionUpdateVenda($id)
	{
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->mostra_vendas) $this->layout='//layouts/column3';
		
		$this->updateOrdem('update','venda','createVenda','updateVenda',
				'_formVendaHeader','_formVenda','addTabularInputsVenda','_tabularInputVenda',$id);
		
	}
	
	public function actionCreateCompra()
	{
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->mostra_compras) $this->layout='//layouts/column3';
		
		$this->createOrdem('create', 'compra', 'createCompra', 'updateCompra',
				'_formCompraHeader', '_formCompra', 'addTabularInputsCompra', '_tabularInputCompra');
		
	}
	
	public function actionUpdateCompra($id)
	{
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->mostra_compras) $this->layout='//layouts/column3';
		
		$this->updateOrdem('update','compra','createCompra','updateCompra',
				'_formCompraHeader','_formCompra','addTabularInputsCompra','_tabularInputCompra',$id);
		
	}
	
	public function actionCreateServico()
	{
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->mostra_servico) $this->layout='//layouts/column3';
		
		$this->createOrdem('create', 'servico', 'createServico', 'updateServico',
				'_formServicoHeader', '_formServico', 'addTabularInputsServico', '_tabularInputServico');
		
	}
	
	public function actionUpdateServico($id)
	{
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->mostra_servico) $this->layout='//layouts/column3';
		
		$this->updateOrdem('update','servico','createServico','updateServico',
				'_formServicoHeader','_formServico','addTabularInputsServico','_tabularInputServico',$id);
		
	}
	
	public function actionCreateOrcamentoServico()
	{
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->mostra_servico) $this->layout='//layouts/column3';
	
		$this->createOrdem('create', 'servico', 'createOrcamentoServico', 'updateOrcamentoServico',
				'_formOrcamentoServicoHeader', '_formOrcamentoServico', 'addTabularInputsOrcamentoServico', '_tabularInputOrcamentoServico');
	
	}
	
	public function actionUpdateOrcamentoServico($id)
	{
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->mostra_servico) $this->layout='//layouts/column3';
	
		$this->updateOrdem('update','servico','createOrcamentoServico','updateOrcamentoServico',
				'_formOrcamentoServicoHeader','_formOrcamentoServico','addTabularInputsOrcamentoServico','_tabularInputOrcamentoServico',$id);
	
	}
	
}