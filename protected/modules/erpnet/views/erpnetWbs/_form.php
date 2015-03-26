<?php
/* @var $this ErpnetWbsController */
/* @var $model ErpnetWbs */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'erpnet-wbs-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_pai'); ?>
		<?php echo $form->DropDownList($model,'id_pai',$model->getItens(false,'estoque'),array('empty'=>'--Nenhum--')); ?>
		<?php echo $form->error($model,'id_pai'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'numero'); ?>
		<?php echo $form->textField($model,'numero',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'numero'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descricao'); ?>
		<?php echo $form->textField($model,'descricao',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'descricao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->DropDownList($model,'tipo',array('producao'=>Helpers::t('appUi','Produção',array(),'i18n',null,false), 'nome'=>Helpers::t('appUi','Padrão',array(),'i18n',null,false), 'estoque'=>'Estoque', 'valores'=>'Valores')); ?>
		<?php echo $form->error($model,'tipo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Helpers::t('app', 'formCreate') : Helpers::t('app', 'formSave')); ?>
<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->