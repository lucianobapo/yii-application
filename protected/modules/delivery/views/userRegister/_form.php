<?php
/* @var $this UserRegisterController */
/* @var $model User */
/* @var $form CActiveForm */
//$endereco = Yii::app()->buscaPorCep->run('12345-678');
//echo '<pre>'.CVarDumper::dumpAsString($endereco).'</pre>';
?>

<div class="">
<?php //echo '<pre>'.CVarDumper::dumpAsString($dados->photoURL).'</pre>';?>
<?php if(Yii::app()->user->hasFlash('erro')): ?>
	<div class="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<?php echo Yii::app()->user->getFlash('erro'); ?>
	</div>
<?php endif; ?>

<?php if( (isset(Yii::app()->user->dados))&&(Yii::app()->user->dados!==null) ): ?>
	<div class="sb5 vb5 square-background square-colored clearfix">
		<div class="sb7 vb7 square square-back pull-left">
			<img class="sim2" alt="<?php echo Helpers::t('appUi','Foto do Perfil social');?>" title="<?php echo Helpers::t('appUi','Foto do Perfil social');?>" src="<?php echo Yii::app()->user->dados['photoURL'];?>">
		</div>
		<h3><?php echo Yii::app()->user->dados['displayName'];?></h3>
		<p><?php echo Helpers::t('appUi', 'Este perfil {perfil} irá se associar ao registro do ',array('{perfil}'=>Yii::app()->user->dados['provider'])).Yii::app()->name;?></p>
	</div>
<?php endif; ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'=> array(
        'novalidate' => 'novalidate',
        'name'=>'user-form',
        //'role'=>'form',
        //'class'=>"form-horizontal",
        'ng-controller'=>"UserFormController as form",
        'verifica'=>Helpers::t('appUi','Este usuário ainda não foi criado!',array(),'i18n',null,false),
    ),
)); ?>

	<p class="note"><?php echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php
	$errors=array();
	if (isset($model)) array_push($errors,$model);
	if (isset($modelParceiro)) array_push($errors,$modelParceiro);
	if (isset($modelAssign)) array_push($errors,$modelAssign);
	echo $form->errorSummary(
		$errors,
		'<button type="button" class="close" data-dismiss="alert">&times;</button>'.
		'<p>'.Yii::t('yii','Please fix the following input errors:').'</p>',
		null,
		array('class'=>'alert alert-danger')
	);

	?>
	
<?php if( (isset(Yii::app()->user->dados))&&(Yii::app()->user->dados!==null) ): ?>
	<?php echo $form->hiddenField($model,'social_identifier',array()) ?>
	<?php echo $form->hiddenField($model,'provider',array()) ?>
	<?php echo $form->hiddenField($modelParceiro,'custom1',array()) ?>
	<?php echo $form->hiddenField($modelParceiro,'custom2',array()) ?>
	<?php //echo $form->hiddenField($model,'email',array('value'=>$dados->userProfile->email)) ?>
	
<?php else: ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>64)); ?>
		<?php //echo $form->textField($model,'username',array('size'=>60,'maxlength'=>64,'value'=>(isset($_GET['user']) ? $_GET['user']:''),'readonly'=>(isset($_GET['user']) ? 'true':''))); ?>
		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
	</div>


<?php endif; ?>
	
	<div class="form-block-delivery" >
		<div class="form-inline-delivery col-sm-3">
			<?php echo $form->labelEx($modelParceiro,'nome',array('class'=>'')); ?>
			<?php echo $form->textField($modelParceiro,'nome',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		</div>
		<div class="form-inline-delivery col-sm-3 has-feedback" ng-class="classFeedback">
			<?php echo $form->labelEx($modelParceiro,'cnpj',array('class'=>'')); ?>
			<?php echo $form->textField($modelParceiro,'cnpj',array('size'=>60,'maxlength'=>14,'class'=>"form-control numbersOnly validaCpfCnpj",'ng-model'=>'cpf','ng-change'=>'change()')); ?>
            <span ng-class="classFeedbackIcon"></span>
		</div>
	</div>

	<div class="form-block-delivery">
		<div class="form-inline-delivery col-sm-3">
			<?php echo $form->labelEx($modelParceiro,'email',array('class'=>'')); ?>
			<?php echo $form->textField($modelParceiro,'email',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
		</div>
		<div class="form-inline-delivery col-sm-3">
            <?php echo $form->labelEx($modelParceiro,'aniversario',array('class'=>'')); ?>
			<div class='input-group date datetimepicker dateOnly'>

			<?php
			echo $form->textField($modelParceiro,'aniversario',array('maxlength'=>10,'class'=>'form-control','placeholder'=>Helpers::t('appUi',Yii::app()->locale->getDateFormat('medium'))));
			/*$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => $modelParceiro,
				'attribute' => 'aniversario',
				'value' => $modelParceiro->aniversario,
				'language'=>'pt',
				// additional javascript options for the date picker plugin
				'options' => array (
					'showAnim' => 'fold',
					'showButtonPanel' => false,
					'autoSize' => true,
				),
				'htmlOptions'=>array(
					'class'=>'form-control sb30',
					'maxlength'=>10,
					'placeholder'=>Helpers::t('appUi',Yii::app()->locale->getDateFormat('medium')),
				),
			) );*/
			?>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>

	<div class="form-block-delivery">
		<div class="form-inline-delivery col-sm-3">
			<?php echo $form->labelEx($modelParceiro,'cep',array('class'=>'')); ?>
			<?php echo $form->textField($modelParceiro,'cep',array('size'=>60,'maxlength'=>8,'class'=>'form-control numbersOnly','placeholder'=>Helpers::t('appUi', '28890001 a 28899999'))); ?>
		</div>
	</div>

	<?php $this->widget('ext.correios.BuscaPorCep', array(
		'jsAction'=>'blur',
		'target'=>'#'.CHtml::activeID($modelParceiro, 'cep'),//'#btnBuscarCep',
		'model'=>$modelParceiro,
		'attribute'=>'cep',
		'url'=>'/' . Helpers::getModuleName() .'/userRegister/buscaPorCep',
		'config'=>array(
			'location'=>'endereco',
			'district'=>'custom3',
			'city'=>'cidade',
			'state'=>'estado',
		),
	)); ?>
	<div class="form-block-delivery">
		<div class="form-inline-delivery col-sm-3">
			<?php echo $form->labelEx($modelParceiro,'cidade',array('class'=>'')); ?>
			<?php echo $form->textField($modelParceiro,'cidade',array('class'=>'form-control')); ?>
		</div>
		<div class="form-inline-delivery col-sm-3">
			<?php echo $form->labelEx($modelParceiro,'custom3',array('class'=>'')); //Bairro ?>
			<?php echo $form->textField($modelParceiro,'custom3',array('class'=>'form-control')); //Bairro ?>
		</div>
	</div>

	<div class="form-block-delivery">
		<div class="form-inline-delivery col-sm-1">
			<?php echo $form->labelEx($modelParceiro,'estado',array('class'=>'')); ?>
			<?php echo $form->textField($modelParceiro,'estado',array('class'=>'form-control')); ?>
		</div>
		<div class="form-inline-delivery col-sm-5">
			<?php echo $form->labelEx($modelParceiro,'endereco',array('class'=>'')); ?>
			<?php echo $form->textField($modelParceiro,'endereco',array('class'=>'form-control')); ?>
		</div>
	</div>

	<div class="form-block-delivery">
		<div class="form-inline-delivery col-sm-3">
			<?php echo $form->labelEx($modelParceiro,'custom4',array('class'=>'')); //Número e complemento ?>
			<?php echo $form->textField($modelParceiro,'custom4',array('class'=>'form-control')); ?>
		</div>
		<div class="form-inline-delivery col-sm-3">
			<?php echo $form->labelEx($modelParceiro,'telefone',array('class'=>'')); ?>
			<?php echo $form->textField($modelParceiro,'telefone',array('class'=>'form-control')); ?>
		</div>
	</div>

	<div class="form-block-delivery buttons">
		<?php echo CHtml::submitButton(Helpers::t('appUi', 'Registrar Usuário',array(),'i18n',null,false),array('class'=>'btn btn-large btn-success','click-once'=>Helpers::t('app', 'Carregando...'))); ?>
		<?php echo $form->hiddenField($modelParceiro,'empresa',array('value'=>'ilhanet')) ?>
		<?php echo $form->hiddenField($model,'empresa',array('value'=>'ilhanet')) ?>
	</div>

<?php $this->endWidget(); ?>

</div>
<!-- form -->