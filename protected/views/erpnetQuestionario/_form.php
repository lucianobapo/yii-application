<?php
/* @var $this ErpnetQuestionarioController */
/* @var $model ErpnetQuestionario */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'erpnet-questionario-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'campo01'); ?>
		<?php echo $form->textField($model,'campo01',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo01'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo02'); ?>
		<?php echo $form->textField($model,'campo02',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo02'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo03'); ?>
		<?php echo $form->textField($model,'campo03',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo03'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo04'); ?>
		<?php echo $form->textField($model,'campo04',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo04'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo05'); ?>
		<?php //echo $form->textField($model,'campo05',array('size'=>60,'maxlength'=>255)); 
				echo $form->DropDownList($model,'campo05',array('1'=>utf8_encode('Sim'), '0'=>utf8_encode('Não')),array());?>
		<?php echo $form->error($model,'campo05'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo06'); ?>
		<?php echo $form->textField($model,'campo06',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo06'); ?>
	</div>

	<div class="row">Caso Sim:<br>
		<?php echo $form->labelEx($model,'campo07'); ?>
		<?php echo $form->textField($model,'campo07',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo07'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo08'); ?>
		<?php echo $form->textField($model,'campo08',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo08'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo09'); ?>
		<?php echo $form->textField($model,'campo09',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo09'); ?>
	</div>

	<div class="row">Caso N&atilde;o:<br>
		<?php echo $form->labelEx($model,'campo10'); ?>
		<?php echo $form->textField($model,'campo10',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo10'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo11'); ?>
		<?php echo $form->textField($model,'campo11',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo11'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo12'); ?>
		<?php echo $form->textField($model,'campo12',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo12'); ?>
	</div>

	<div class="row"><br><br>
		<?php echo $form->labelEx($model,'campo13'); ?>
		<?php echo $form->textField($model,'campo13',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo13'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo14'); ?>
		<?php echo $form->textField($model,'campo14',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo14'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campo15'); ?>
		<?php echo $form->textField($model,'campo15',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'campo15'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? utf8_encode(Yii::t('app', 'formCreate', array(), 'i18n')) : utf8_encode(Yii::t('app', 'formSave', array(), 'i18n'))); ?>
<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->