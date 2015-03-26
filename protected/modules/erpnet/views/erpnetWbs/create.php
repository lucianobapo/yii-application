<?php
/* @var $this ErpnetWbsController */
/* @var $model ErpnetWbs */

$this->breadcrumbs=array(
	utf8_encode(Yii::t('erpnetUi', 'breadWbs', array(), 'i18n'))=>array('admin'),
	utf8_encode(Yii::t('app', 'breadCreate', array(), 'i18n')),
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>utf8_encode(Yii::t('app', 'menuManage', array(), 'i18n')), 'url'=>array('admin')),
);
?>

<h3><?php echo utf8_encode(Yii::t('erpnetUi', 'viewCreateWbsTitle', array(), 'i18n'));?></h3>

<?php if(Yii::app()->user->hasFlash('wbs')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('wbs'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>