<?php
/* @var $this ErpnetClienteController */
/* @var $model ErpnetCliente */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'erpnet-cliente-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="controls-row">
		<?php echo $form->labelEx($model,'nome',array('class'=>'span3')); ?>
		<?php echo $form->labelEx($model,'cnpj',array('class'=>'span3')); ?>
		
	</div>
	<div class="controls-row">
		<?php echo $form->textField($model,'nome',array('size'=>60,'maxlength'=>255,'class'=>'span3')); ?>
		<?php echo $form->textField($model,'cnpj',array('size'=>60,'maxlength'=>255,'class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'nome',array('class'=>'span3')); ?>
		<?php echo $form->error($model,'cnpj',array('class'=>'span3')); ?>
	</div>

	<div class="controls-row">
		<?php echo $form->labelEx($model,'email',array('class'=>'span3')); ?>
		<?php echo $form->labelEx($model,'telefone',array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>'span3')); ?>
		<?php echo $form->textField($model,'telefone',array('size'=>60,'maxlength'=>255,'class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'email',array('class'=>'span3')); ?>
		<?php echo $form->error($model,'telefone',array('class'=>'span3')); ?>
	</div>
	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'endereco',array('class'=>'span3')); ?>
		<?php echo $form->labelEx($model,'contato',array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->textField($model,'endereco',array('size'=>60,'maxlength'=>255,'class'=>'span3')); ?>
		<?php echo $form->textField($model,'contato',array('size'=>60,'maxlength'=>255,'class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'endereco',array('class'=>'span3')); ?>
		<?php echo $form->error($model,'contato',array('class'=>'span3')); ?>
	</div>

	<div class="controls-row">
		<?php echo $form->labelEx($model,'obs',array('class'=>'span3')); ?>
		
		
	</div>
	<div class="controls-row">
		<?php echo $form->textField($model,'obs',array('size'=>60,'maxlength'=>255,'class'=>'span6')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'obs',array('class'=>'span3')); ?>
	</div>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'tipo_cliente' , array()); ?>
		<?php echo $form->labelEx($model,'tipo_cliente', array('class'=>'span2')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'tipo_cliente', array('class'=>'span3')); ?>
	</div>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'tipo_fornecedor' , array()); ?>
		<?php echo $form->labelEx($model,'tipo_fornecedor', array('class'=>'span2')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'tipo_fornecedor', array('class'=>'span3')); ?>
	</div>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'tipo_associado' , array()); ?>
		<?php echo $form->labelEx($model,'tipo_associado', array('class'=>'span2')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'tipo_associado', array('class'=>'span3')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? utf8_encode(Yii::t('app', 'formCreate', array(), 'i18n')) : utf8_encode(Yii::t('app', 'formSave', array(), 'i18n'))); ?>
		<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->