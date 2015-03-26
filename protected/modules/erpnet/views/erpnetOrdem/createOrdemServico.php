<?php
/* @var $this ErpnetOrdemController */
/* @var $model ErpnetOrdem */
/* @var $modelOrdemItem ErpnetOrdemItem */
/* @var $modelEstoque ErpnetEstoque */
/* @var $modelFatura ErpnetFatura */
/* @var $tabular array() XTabularInput */
?>

<?php $this->renderPartial($fileFormHeader, array()); ?>

<?php if(Yii::app()->user->hasFlash('ordem')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('ordem'); ?>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('erro')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('erro'); ?>
</div>
<?php endif; ?>


<div class="form">

<?php 

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'erpnet-ordem-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note"><?php echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php if (isset($model)) echo $form->errorSummary($model); ?>
	<?php if (isset($modelEstoque)) echo $form->errorSummary($modelEstoque); ?>
	<?php if (isset($modelFatura)) echo $form->errorSummary($modelFatura); ?>
	<?php if (isset($modelPagar)) echo $form->errorSummary($modelPagar); ?>
	<?php if (isset($modelOrdemItem)) echo $form->errorSummary($modelOrdemItem); ?>
	<?php if (isset($modelOrdemItem2)) 
		foreach ($modelOrdemItem2 as $key=>$value) echo $form->errorSummary($value); ?>

	<?php 
	//*
	$this->renderPartial($fileForm, array(
		'model'=>$model,
		'form'=>$form,
		//'modelEstoque'=>$modelEstoque,
		//'modelFatura'=>$modelFatura,
		'modelOrdemItem'=>$modelOrdemItem,
		'tabular'=>$tabular,
		//'tipo'=>$tipo,
		'debug'=>$debug,
	));//*/ ?>
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Helpers::t('app', 'formCreate') : Helpers::t('app', 'formSave')); ?>
		<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
		<?php echo $form->hiddenField($model,'usuario',array('value'=>Yii::app()->user->name)) ?>
		
	</div>

<?php $this->endWidget(); //var_dump($debug);?>

</div>
<!-- form -->