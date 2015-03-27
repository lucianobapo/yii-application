<?php

class DeliveryEnderecoController extends Controller
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
            //'postOnly + principal', // we only allow deletion via POST request
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
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('principal','cancel','create','update'),
				'roles'=>array('deliveryPedidos'),
			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('buscaPorCep'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new DeliveryEndereco;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DeliveryEndereco']))
		{
			$model->attributes=$_POST['DeliveryEndereco'];
			if($model->save()) {
                Yii::app()->user->setFlash('success',Helpers::t('appUi', 'Endereço criado com sucesso!'));
                $this->redirect(array('create'));
            }

		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['DeliveryEndereco']))
		{
			$model->attributes=$_POST['DeliveryEndereco'];
			if($model->save()) {
				//EQuickDlgs::checkDialogJsScript();
                Yii::app()->user->setFlash('success',Helpers::t('appUi', 'Endereço atualizado com sucesso!'));
				$this->redirect(array('create'));
			}
		}

		//EQuickDlgs::render('update',array('model'=>$model));
        $this->render('update',array(
            'model'=>$model,
        ));
	}

    public function actionPrincipal($id)
    {
        //echo ('<pre>'.CVarDumper::dumpAsString($id).'</pre>');
        $model=$this->loadModel($id);
        //echo ('<pre>'.CVarDumper::dumpAsString($model).'</pre>');
        //if ($model->principal==1) return false;

        if ( ($model->principal==1)||($model->status_cancelado==1)||($model->usuario!=Yii::app()->user->social_identifier) ){
            Yii::app()->user->setFlash('erro',Helpers::t('appUi', 'Erro: Endereço Inválido.'));
            $this->redirect(array('create'));
            return;
        }

        $principal=DeliveryEndereco::model()->findByAttributes(array(
            'empresa'=>'ilhanet',
            'usuario'=>Yii::app()->user->social_identifier,
            'principal'=>1,
        ));
        $principal->principal=0;
        //echo ('<pre>'.CVarDumper::dumpAsString($principal).'</pre>');
        //*
        if ($principal->save()) {
            $model->principal=1;
            $model->save();

        }//*/

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax'])) $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('create'));
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
        //$modelCache=new DbAccess();
        //$modelEndereco=$modelCache->getEndereco($id);
        //https://delivery.localhost.com/delivery/deliveryEndereco/principal/id/8.html
        $modelEndereco=DeliveryEndereco::model()->findByPk($id);

        if ( ($modelEndereco->principal==1)||($modelEndereco->status_cancelado==1)||($modelEndereco->usuario!=Yii::app()->user->social_identifier) ){
            Yii::app()->user->setFlash('erro',Helpers::t('appUi', 'Erro: Endereço Inválido.'));
            $this->redirect(array('create'));
            return;
        }

        $modelEndereco->status_cancelado=1;
        $modelEndereco->save();
        /*
        if ($modelEndereco->save()) {
            Yii::app()->user->setFlash('alert',Helpers::t('appUi', 'Endereço cancelado com sucesso.'));
            $this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryEndereco/create'));
        }else{
            Yii::app()->user->setFlash('erro',Helpers::t('appUi', 'Erro ao cancelar o Endereco.'));
            $this->redirect($this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryEndereco/create'));
        }*/

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('create'));
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
		$model=new DeliveryEndereco('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DeliveryEndereco']))
			$model->attributes=$_GET['DeliveryEndereco'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DeliveryEndereco the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DeliveryEndereco::model()->findByPk($id);
		//if($model===null)
		if ( ($model===null) || ( (Yii::app()->user->empresa!=$model->empresa) && (!Yii::app()->user->checkAccess('admin')) ) )
			throw new CHttpException(404,utf8_encode(Yii::t('app', 'appFormLabel5', array(), 'i18n')));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DeliveryEndereco $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='delivery-endereco-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
