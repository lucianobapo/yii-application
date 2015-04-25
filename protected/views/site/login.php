<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h3>Login</h3>
<?php //var_dump($mostra); ?>
<p><?php echo Yii::t('app', 'loginLabel1', array(), 'i18n'); ?></p>

<?php if(Yii::app()->user->hasFlash('erro')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('erro'); ?>
</div>
<?php endif; ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note"><?php echo Yii::t('app', 'appFormLabel1', array('{req}'=>'<span class="required">*</span>'), 'i18n'); ?></p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?> 
	</div>
	

<?php $this->endWidget(); ?>
</div><!-- form -->
