<?php

class ErpnetWbsController extends Controller
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
				'actions'=>array('index','admin','view','create','create2','update','delete'),
				'roles'=>array('erpnetManageWbs'),
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
		$model=new ErpnetWbs;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ErpnetWbs']))
		{
			$model->attributes=$_POST['ErpnetWbs'];
			if($model->save()) {
				Yii::app()->user->setFlash('wbs',utf8_encode(Yii::t('erpnetUi', 'viewCreateFlash', array(), 'i18n')));
				$this->redirect(array('create'));
			}
				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionCreate2()
	{
		
		$criteria=new CDbCriteria;
		$criteria->compare('empresa',Yii::app()->user->empresa);
		$criteria->compare('tipo','producao');
		$model=ErpnetWbs::model ()->findAll($criteria);
		$sucesso=0;
		$erro=0;
		$debug='';
		foreach ($model as $key => $value) {
			$model2=new ErpnetWbs;
			$model2->empresa=$value->empresa;
			$model2->id_pai=$value->id_pai;
			$model2->numero=$value->numero;
			$model2->descricao=$value->descricao.'-Consumo';
			$model2->tipo='valores';
			$debug=$debug.' - '.$model2->descricao;
			//if ($model2->save()) $sucesso++;
			//else 
				$erro++;
		}
	
		Yii::app()->user->setFlash('wbs','Suc:'.$sucesso.' Err:'.$erro.$debug.utf8_encode(Yii::t('erpnetUi', 'viewCreateFlash', array(), 'i18n')));
		$this->redirect(array('create'));
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

		if(isset($_POST['ErpnetWbs']))
		{
			$model->attributes=$_POST['ErpnetWbs'];
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
		$model=new ErpnetWbs('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ErpnetWbs']))
			$model->attributes=$_GET['ErpnetWbs'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ErpnetWbs the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ErpnetWbs::model()->findByPk($id);
		//if($model===null)
		if ( ($model===null) || ( (Yii::app()->user->empresa!=$model->empresa) && (!Yii::app()->user->checkAccess('admin')) ) )
			throw new CHttpException(404,utf8_encode(Yii::t('app', 'appFormLabel5', array(), 'i18n')));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ErpnetWbs $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='erpnet-wbs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
