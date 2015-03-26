<?php
/* @var $this ErpnetComprasController */
/* @var $model ErpnetCompras */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'empresa'); ?>
		<?php echo $form->textField($model,'empresa',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'num_ordem'); ?>
		<?php echo $form->textField($model,'num_ordem',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_criacao'); ?>
		<?php echo $form->textField($model,'data_criacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_emissao'); ?>
		<?php echo $form->textField($model,'data_emissao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'moeda'); ?>
		<?php echo $form->textField($model,'moeda',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'conversao_brl'); ?>
		<?php echo $form->textField($model,'conversao_brl'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'incoterm'); ?>
		<?php echo $form->textField($model,'incoterm',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'incoterm_local'); ?>
		<?php echo $form->textField($model,'incoterm_local',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'texto'); ?>
		<?php echo $form->textArea($model,'texto',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'formSearch', array(), 'i18n')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->