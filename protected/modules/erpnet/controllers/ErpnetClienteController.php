<?php

class ErpnetClienteController extends Controller
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
				'actions'=>array('admin','view','create','create2','update','delete','ativar'),
				'roles'=>array('erpnetManageCliente'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'roles'=>array('erpnetManageCliente'),
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
		$model=new ErpnetCliente;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ErpnetCliente']))
		{
			$model->attributes=$_POST['ErpnetCliente'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionCreate2()
	{
		/*
		 *     
	ok0 => 'nome beneficiario'
    ok1 => 'endereco'
    ok2 => 'numero'
    ok3 => 'bairro'
    ok4 => 'cep'
    ok5 => 'cidade'
    ok6 => 'uf'
    ok7 => 'nu-ddd'
    ok8 => 'nu-telefone'
    ok9 => 'vl-atual-benef'
    ok10 => 'nu-nb'
    ok11 => 'nu-cpf'
    ok12 => 'dv-cpf'
    ok13 => 'esp'
    ok14 => 'dib'
    ok15 => 'ddb'
    ok16 => 'dt-nasc'
    ok17 => 'aps-concessao'
    ok18 => 'id-banco'
    ok19 => 'id-orgao-pagador'
    ok20 => 'instituicao'
    ok21 => 'erro_matricula'
    ok22 => 'status'
    ok23 => 'representante-legal'
		 */
		
		//$model=new ErpnetCliente;
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		//$limite=30000;
		die('desativado');
		
		if ($f = fopen($_SERVER['DOCUMENT_ROOT'].'/protected/data/clientes_ok.csv', 'r')) {
			
			
			//$valida=array();
			//$f_ok = fopen($_SERVER['DOCUMENT_ROOT'].'/protected/data/clientes_ok2.csv', 'a');
			//$f_err = fopen($_SERVER['DOCUMENT_ROOT'].'/protected/data/clientes_err.csv', 'a');
			//$linha = fgetcsv($f, 0, ';', '"');
			set_time_limit(400);
			$i=1;
			echo 'inicio...';
			$model=new ErpnetCliente;
			$transaction=$model->dbConnection->beginTransaction();
			//if (!ob_start()) die('erro no buffer');
			//while ( (!feof($f))&&($i<=$limite) ) {
			while (!feof($f)) {
				
				
				$model->unsetAttributes(array(
					'nome',
					'tipo_cliente',
					'empresa',
					'cnpj',
					'endereco',
					'cep',
					'cidade',
					'estado',
					'cod_area',
					'telefone',
					'aniversario',
					'banco',
					'matricula',
					'instituicao',
					'erro_matricula',
					'custom1',
						'custom2',
						'custom3',
						'custom4',
						'custom5',
						'custom6',
						'custom7',
						'custom8',
				));
				$linha = fgetcsv($f, 0, ';', '"');
				/*
				if ($linha[11]!='') {
					$cnpj=$linha[11];
					if ($linha[12]!='') $cnpj=$cnpj.$linha[12];
					
					if (array_key_exists($cnpj, $valida)) {
						fputcsv($f_err, $linha, ';', '"');
					} else {
						$valida[$cnpj]=true;
						fputcsv($f_ok, $linha, ';', '"');
					}
				}*/
				//*
				//nome
				if ($linha[0]!='') {
					$model->nome=$linha[0];
					
					//obrigatórios
					$model->tipo_cliente=1;
					$model->empresa='telemark';
					
					//cpf
					if ($linha[11]!='') {
						$model->cnpj=$linha[11];
						if ($linha[12]!='') $model->cnpj=$model->cnpj.$linha[12];
					}
					
					//endereco
					if ($linha[1]!='') {
						$model->endereco=$linha[1];
						if ($linha[2]!='') $model->endereco=$model->endereco.', '.$linha[2];
						if ($linha[3]!='') $model->endereco=$model->endereco.' - '.$linha[3];
					}
					
					//cep
					if ($linha[4]!='') $model->cep=$linha[4];
					
					//cidade
					if ($linha[5]!='') $model->cidade=$linha[5];
					
					//estado
					if ($linha[6]!='') $model->estado=$linha[6];
					
					//codarea
					if ($linha[7]!='') $model->cod_area=$linha[7];
					
					//telefone
					if ($linha[8]!='') $model->telefone=$linha[8];
					
					//aniversario
					if ($linha[16]!='') $model->aniversario=$linha[16];
					
					//banco
					if ($linha[18]!='') $model->banco=$linha[18];
					
					//matricula
					if ($linha[19]!='') $model->matricula=$linha[19];
					
					//instituicao
					if ($linha[20]!='') $model->instituicao=$linha[20];
					
					//erro_matricula
					if ( ($linha[21]!='')&&($linha[21]=='VERDADEIRO') ) $model->erro_matricula=1;
					elseif ( ($linha[21]!='')&&($linha[21]=='FALSO') ) $model->erro_matricula=0;
					
					//custom1
					if ($linha[9]!='') $model->custom1=$linha[9];
					//custom2
					if ($linha[10]!='') $model->custom2=$linha[10];
					//custom3
					if ($linha[13]!='') $model->custom3=$linha[13];
					//custom4
					if ($linha[14]!='') $model->custom4=$linha[14];
					//custom5
					if ($linha[15]!='') $model->custom5=$linha[15];
					//custom6
					if ($linha[17]!='') $model->custom6=$linha[17];
					//custom7
					if ($linha[22]!='') $model->custom7=$linha[22];
					//custom8
					if ($linha[23]!='') $model->custom8=$linha[23];
					
					echo $i.'<br>';
					$i=$i+1;
					if (!$model->save()) {
						$transaction->rollback();
						echo '<pre>'.CVarDumper::dumpAsString($model).'</pre>';
						die;
					}
					
						//echo '<pre>'.CVarDumper::dumpAsString($model).'</pre>';
					
					/*
					if (!$transaction->getActive()) {
						fclose($f);
						echo '<pre>'.CVarDumper::dumpAsString($model).'</pre>';
						die;
					}*/
					
				}
				//*/
				
			}
			//ob_flush();
			echo 'acabou...';
			
			if ($transaction->getActive()) {
				$transaction->commit();
				echo '<pre>'.CVarDumper::dumpAsString($model).'</pre>';
			}
			//echo '<pre>'.CVarDumper::dumpAsString($valida).'</pre>';
			
			/*
			while ( (!feof($f))&&($i>$limite) ) {
				$linha = fgetcsv($f, 0, ';', '"');
				fputcsv($f_ok, $linha, ';', '"');
			}*/
			fclose($f);
			//fclose($f_ok);
			//fclose($f_err);
			
			//fread($f, $length);
			//fwrite($f, "\n".$msg."\n");
			
			//return true;
		} //else return false;
		//var_dump($linha);
		/*
		if(isset($_POST['ErpnetCliente']))
		{
			$model->attributes=$_POST['ErpnetCliente'];
			if($model->save())
				$this->redirect(array('admin'));
		}
	
		$this->render('create',array(
				'model'=>$model,
		));*/
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

		if(isset($_POST['ErpnetCliente']))
		{
			$model->attributes=$_POST['ErpnetCliente'];
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
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ErpnetCliente('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ErpnetCliente']))
			$model->attributes=$_GET['ErpnetCliente'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ErpnetCliente the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ErpnetCliente::model()->findByPk($id);
		//if($model===null)
		if ( ($model===null) || ( (Yii::app()->user->empresa!=$model->empresa) && (!Yii::app()->user->checkAccess('admin')) ) )
			throw new CHttpException(404,utf8_encode(Yii::t('app', 'appFormLabel5', array(), 'i18n')));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ErpnetCliente $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='erpnet-cliente-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
