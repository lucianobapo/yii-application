<?php
/* @var $this DeliveryEnderecoController */
/* @var $model DeliveryEndereco */

$this->breadcrumbs=array();

$this->menu=array();
?>

    <h1><?php echo Helpers::t('appUi','{empresa} - Endereços',array('{empresa}'=>Yii::app()->name));?></h1>

<article>
    <?php if(Yii::app()->user->hasFlash('erro')): ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <?php echo Yii::app()->user->getFlash('erro'); ?>
        </div>
    <?php endif; ?>

    <?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php if(Yii::app()->user->hasFlash('alert')): ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('alert'); ?>
        </div>
    <?php endif; ?>
</article>

    <?php $this->renderPartial('_form', array('model'=>$model)); ?>

