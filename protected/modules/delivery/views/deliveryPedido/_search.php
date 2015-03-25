<?php
/* @var $this DeliveryPedidoController */
/* @var $model DeliveryPedido */
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
		<?php echo $form->textField($model,'empresa',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_criacao'); ?>
		<?php echo $form->textField($model,'data_criacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_inicio'); ?>
		<?php echo $form->textField($model,'data_inicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_termino'); ?>
		<?php echo $form->textField($model,'data_termino',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_produto'); ?>
		<?php echo $form->textField($model,'id_produto'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_wbs'); ?>
		<?php echo $form->textField($model,'id_wbs'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_wbs_destino'); ?>
		<?php echo $form->textField($model,'id_wbs_destino'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_cliente'); ?>
		<?php echo $form->textField($model,'id_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'turno'); ?>
		<?php echo $form->textField($model,'turno',array('size'=>0,'maxlength'=>0)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantidade'); ?>
		<?php echo $form->textField($model,'quantidade'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'valor'); ?>
		<?php echo $form->textField($model,'valor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'moeda'); ?>
		<?php echo $form->textField($model,'moeda',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo'); ?>
		<?php echo $form->textField($model,'tipo',array('size'=>0,'maxlength'=>0)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pagamento'); ?>
		<?php echo $form->textField($model,'pagamento',array('size'=>0,'maxlength'=>0)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'texto_header'); ?>
		<?php echo $form->textArea($model,'texto_header',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'referencia'); ?>
		<?php echo $form->textField($model,'referencia',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'obs'); ?>
		<?php echo $form->textField($model,'obs',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status_fechado'); ?>
		<?php echo $form->textField($model,'status_fechado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'formSearch', array(), 'i18n')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->