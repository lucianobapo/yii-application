<?php
/* @var $this ErpnetClienteController */
/* @var $model ErpnetCliente */

$this->breadcrumbs=array(
	utf8_encode(Yii::t('erpnetUi', 'breadClientes', array(), 'i18n'))=>array('admin'),
	utf8_encode(Yii::t('app', 'breadCreate', array(), 'i18n')),
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>utf8_encode(Yii::t('app', 'menuManage', array(), 'i18n')), 'url'=>array('admin')),
);
?>

<h3><?php echo utf8_encode(Yii::t('app', 'breadCreate', array(), 'i18n'));?> <?php echo utf8_encode(Yii::t('erpnetUi', 'viewCreateClientesTitle', array(), 'i18n')); ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>