<?php
/* @var $this ErpnetConfigController */
/* @var $model ErpnetConfig */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'empresa'); ?>
		<?php echo $form->textField($model,'empresa',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mostra_lang'); ?>
		<?php echo $form->textField($model,'mostra_lang'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'formSearch', array(), 'i18n')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->