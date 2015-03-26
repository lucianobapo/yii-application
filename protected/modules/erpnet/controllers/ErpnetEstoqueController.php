<?php

class ErpnetEstoqueController extends Controller
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
				'actions'=>array('create','create2'),
				'roles'=>array('erpnetManageAjuste'),
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
		$model=new ErpnetEstoque('manual');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ErpnetEstoque']))
		{
			$model->attributes=$_POST['ErpnetEstoque'];
			$model->data_movimento=CDateTimeParser::parse($model->data_movimento, Yii::app()->locale->dateFormat);
			if ( ($model->tipo=='entrada')&& ($model->quantidade < 0) )
					$model->quantidade = $model->quantidade * (- 1);
			elseif ( ($model->tipo=='saida')&& ($model->quantidade > 0) )
					$model->quantidade = $model->quantidade * (- 1);
			
			if($model->save()) {
				Helpers::setFlash('ordem', Helpers::t('erpnetUi', 'viewCreateFlash').' - '.Yii::app()->dateFormatter->formatDateTime(CTimestamp));
				$this->redirect(array('create'));
			}
			//else Helpers::setFlash('erro', 'erro');
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionCreate2()
	{
		
		$model= new ErpnetOrdem;
		//$model->deleteAllByAttributes($attributes);
		//$model->delete();
		$criteria=new CDbCriteria;
		$criteria->compare('usuario','olga');
		$criteria->compare('id_ordem','NULL');
		$criteria->order='id_ordem';
		//$criteria->compare('data_movimento',$this->data_movimento);
		
		$modelEstoque=ErpnetEstoque::model()->findAll($criteria);
		
		$attributes=array(
			'usuario'=>'olga',
			'id_ordem'=>null,
		);
		$modelEstoque=ErpnetEstoque::model()->findAllByAttributes($attributes);
		//$modelEstoque=ErpnetEstoque::model()->countByAttributes($attributes);
		$i=0;
		foreach ($modelEstoque as $key => $value) {
			
			$attributes=array(
					'usuario'=>'olga',
					'data_termino'=>$value->data_movimento,
					'quantidade'=>$value->quantidade,
					'id_wbs'=>$value->id_wbs,
			);
			$modelOrdem=ErpnetOrdem::model()->findByAttributes($attributes);
			$value->id_ordem=$modelOrdem->id;
			//$value->save();
			$i=$i+1;
			//$modelOrdem=ErpnetOrdem::model()->countByAttributes($attributes);
			//if (ErpnetOrdem::model()->countByAttributes($attributes)>1) {
				//
				//retira duplicado
				//ErpnetEstoque::model()->findAllByAttributes($attributes);
				//echo $value->delete();
				//echo ErpnetOrdem::model()->deleteAllByAttributes($attributes);
			//}
				//echo '<pre>'.CVarDumper::dumpAsString($modelOrdem).'</pre>';
		}
		echo $i;
		//echo '<pre>'.CVarDumper::dumpAsString($modelEstoque).'</pre>';
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		
		
		/*
		 if(isset($_POST['ErpnetEstoque']))
		{
			$model->attributes=$_POST['ErpnetEstoque'];
			$model->data_movimento=CDateTimeParser::parse($model->data_movimento, Yii::app()->locale->dateFormat);
			if($model->save()) {
				Helpers::setFlash('ordem', Helpers::t('erpnetUi', 'viewCreateFlash').' - '.Yii::app()->dateFormatter->formatDateTime(CTimestamp));
				$this->redirect(array('create'));
			}
			else
				Helpers::setFlash('erro', 'erro');
		}
	
		$this->render('create',array(
				'model'=>$model,
		));
		//*/
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

		if(isset($_POST['ErpnetEstoque']))
		{
			$model->attributes=$_POST['ErpnetEstoque'];
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
		$model=new ErpnetEstoque('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ErpnetEstoque']))
			$model->attributes=$_GET['ErpnetEstoque'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ErpnetEstoque the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ErpnetEstoque::model()->findByPk($id);
		//if($model===null)
		if ( ($model===null) || ( (Yii::app()->user->empresa!=$model->empresa) && (!Yii::app()->user->checkAccess('admin')) ) )
			throw new CHttpException(404,utf8_encode(Yii::t('app', 'appFormLabel5', array(), 'i18n')));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ErpnetEstoque $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='erpnet-estoque-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
