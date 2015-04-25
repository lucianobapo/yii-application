<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

//$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	utf8_encode(Yii::t('erpnetUi', 'viewTrocaSenha', array(), 'i18n')),
);
?>

<h3><?php echo utf8_encode(Yii::t('erpnetUi', 'viewTrocaSenhaTitle', array(), 'i18n')); ?> <?php echo Yii::app()->user->name; ?></h3>

<?php //var_dump($mostra); ?>

<?php if(Yii::app()->user->hasFlash('erro')): ?>

<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('erro'); ?>
</div>

<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('trocaSenha')): ?>

<div class="flash-notice">
	<?php echo Yii::app()->user->getFlash('trocaSenha'); ?>
</div>

<?php endif; ?>



<?php if(Yii::app()->user->hasFlash('troca')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('troca'); ?>
</div>

<?php else: ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'troca-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note"><?php echo Yii::t('app', 'appFormLabel1', array('{req}'=>'<span class="required">*</span>'), 'i18n'); ?></p>
	
	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'old_password'); ?>
		<?php echo $form->passwordField($model,'old_password'); ?>
		<?php echo $form->error($model,'old_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_password'); ?>
		<?php echo $form->passwordField($model,'new_password'); ?>
		<?php echo $form->error($model,'new_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_password2'); ?>
		<?php echo $form->passwordField($model,'new_password2'); ?>
		<?php echo $form->error($model,'new_password2'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(utf8_encode(Yii::t('erpnetUi', 'viewTrocaSenhaEnviar', array(), 'i18n'))); ?>
		<?php echo $form->hiddenField($model,'username',array('value'=>Yii::app()->user->name)) ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<?php endif; //echo Yii::app()->user->name;?>
