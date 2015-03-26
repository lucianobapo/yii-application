<?php

class ErpnetProdutoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			//'postOnly + ativar', // we only allow deletion via POST request
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
				'actions'=>array('index','admin','create','update','delete','ativar'),
				'roles'=>array('erpnetManageProdutos'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view'),
				'roles'=>array('erpnetManageProdutos'),
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
		$model=new ErpnetProduto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ErpnetProduto']))
		{
			$model->attributes=$_POST['ErpnetProduto'];
			if($model->save()) {
				foreach ($_POST['ErpnetProduto']['erpnetGrupoProdutos'] as $itemnameId) {
					$postErpnetGrupoHasProduto = new ErpnetGrupoHasProduto;
					$postErpnetGrupoHasProduto->id_produto = $model->id;
					$postErpnetGrupoHasProduto->id_grupo_produto = $itemnameId;
					$postErpnetGrupoHasProduto->save();
				}
				$this->redirect(array('admin'));
			}
		}
		$itens_descricao=ErpnetProduto::getItens3();
		$this->render('create',array(
			'model'=>$model,'itens_descricao'=>$itens_descricao,
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
		if (strpos($model->valor, '.'))
			$model->valor = str_replace('.', ',', $model->valor);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ErpnetProduto']))
		{
			$model->attributes=$_POST['ErpnetProduto'];
			
			if($model->save()) {
				$criteria=new CDbCriteria;
				$criteria->condition='id_produto=:id_produto';
				$criteria->params=array(':id_produto'=>$model->id);
				ErpnetGrupoHasProduto::model()->deleteAll($criteria);
				foreach ($_POST['ErpnetProduto']['erpnetGrupoProdutos'] as $itemnameId) {
					$postErpnetGrupoHasProduto = new ErpnetGrupoHasProduto;
					$postErpnetGrupoHasProduto->id_produto = $model->id;
					$postErpnetGrupoHasProduto->id_grupo_produto = $itemnameId;
					$postErpnetGrupoHasProduto->save();
				}
				EQuickDlgs::checkDialogJsScript();
				$this->redirect(array('admin'));
			}
		}
		$itens_descricao=ErpnetProduto::getItens2();
		EQuickDlgs::render('update',array('model'=>$model,'itens_descricao'=>$itens_descricao,));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model=$this->loadModel($id);
		$model->ativado=0;
		$model->save();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionAtivar($id)
	{
		$model=$this->loadModel($id);
		$model->ativado=1;
		$model->save();
	
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{		
		$criteria=new CDbCriteria;
		$criteria->compare('empresa',Yii::app()->user->empresa);
		
		$dataProvider=new CActiveDataProvider('ErpnetProduto');
		$dataProvider->criteria=$criteria;
		$dataProvider->setPagination(false);
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ErpnetProduto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ErpnetProduto']))
			$model->attributes=$_GET['ErpnetProduto'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ErpnetProduto the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ErpnetProduto::model()->findByPk($id);
		//if($model===null)
		if ( ($model===null) || ( (Yii::app()->user->empresa!=$model->empresa) && (!Yii::app()->user->checkAccess('admin')) ) )
			throw new CHttpException(404,utf8_encode(Yii::t('app', 'appFormLabel5', array(), 'i18n')));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ErpnetProduto $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='erpnet-produto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
