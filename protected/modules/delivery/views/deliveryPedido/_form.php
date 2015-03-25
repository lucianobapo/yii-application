<?php
/* @var $this DeliveryPedidoController */
/* @var $model DeliveryPedido */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'delivery-pedido-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'empresa'); ?>
		<?php echo $form->textField($model,'empresa',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'empresa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_criacao'); ?>
		<?php echo $form->textField($model,'data_criacao'); ?>
		<?php echo $form->error($model,'data_criacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_inicio'); ?>
		<?php echo $form->textField($model,'data_inicio'); ?>
		<?php echo $form->error($model,'data_inicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_termino'); ?>
		<?php echo $form->textField($model,'data_termino',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'data_termino'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_produto'); ?>
		<?php echo $form->textField($model,'id_produto'); ?>
		<?php echo $form->error($model,'id_produto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_wbs'); ?>
		<?php echo $form->textField($model,'id_wbs'); ?>
		<?php echo $form->error($model,'id_wbs'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_wbs_destino'); ?>
		<?php echo $form->textField($model,'id_wbs_destino'); ?>
		<?php echo $form->error($model,'id_wbs_destino'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cliente'); ?>
		<?php echo $form->textField($model,'id_cliente'); ?>
		<?php echo $form->error($model,'id_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'turno'); ?>
		<?php echo $form->textField($model,'turno',array('size'=>0,'maxlength'=>0)); ?>
		<?php echo $form->error($model,'turno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantidade'); ?>
		<?php echo $form->textField($model,'quantidade'); ?>
		<?php echo $form->error($model,'quantidade'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor'); ?>
		<?php echo $form->textField($model,'valor'); ?>
		<?php echo $form->error($model,'valor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'moeda'); ?>
		<?php echo $form->textField($model,'moeda',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'moeda'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->textField($model,'tipo',array('size'=>0,'maxlength'=>0)); ?>
		<?php echo $form->error($model,'tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pagamento'); ?>
		<?php echo $form->textField($model,'pagamento',array('size'=>0,'maxlength'=>0)); ?>
		<?php echo $form->error($model,'pagamento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'texto_header'); ?>
		<?php echo $form->textArea($model,'texto_header',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'texto_header'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'referencia'); ?>
		<?php echo $form->textField($model,'referencia',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'referencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'obs'); ?>
		<?php echo $form->textField($model,'obs',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'obs'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_fechado'); ?>
		<?php echo $form->textField($model,'status_fechado'); ?>
		<?php echo $form->error($model,'status_fechado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? utf8_encode(Yii::t('app', 'formCreate', array(), 'i18n')) : utf8_encode(Yii::t('app', 'formSave', array(), 'i18n'))); ?>
<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->