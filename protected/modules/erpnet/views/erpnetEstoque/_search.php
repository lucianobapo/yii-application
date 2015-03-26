<?php
/* @var $this ErpnetEstoqueController */
/* @var $model ErpnetEstoque */
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
		<?php echo $form->label($model,'id_produto'); ?>
		<?php echo $form->textField($model,'id_produto'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_ordem'); ?>
		<?php echo $form->textField($model,'id_ordem'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_wbs'); ?>
		<?php echo $form->textField($model,'id_wbs'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descricao_wbs'); ?>
		<?php echo $form->textField($model,'descricao_wbs',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_criacao'); ?>
		<?php echo $form->textField($model,'data_criacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_movimento'); ?>
		<?php echo $form->textField($model,'data_movimento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantidade'); ?>
		<?php echo $form->textField($model,'quantidade'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'turno'); ?>
		<?php echo $form->textField($model,'turno',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo'); ?>
		<?php echo $form->textField($model,'tipo',array('size'=>0,'maxlength'=>0)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'formSearch', array(), 'i18n')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->