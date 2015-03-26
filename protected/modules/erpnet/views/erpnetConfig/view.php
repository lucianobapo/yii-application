<?php
/* @var $this ErpnetConfigController */
/* @var $model ErpnetConfig */

$this->breadcrumbs=array(
	'Erpnet Configs'=>array('admin'),
	$model->empresa,
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>utf8_encode(Yii::t('app', 'menuCreate', array(), 'i18n')), 'url'=>array('create')),
	//array('label'=>Yii::t('app', 'menuUpdate', array(), 'i18n'), 'url'=>array('update', 'id'=>$model->empresa)),
	//array('label'=>Yii::t('app', 'menuDelete', array(), 'i18n'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->empresa),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>utf8_encode(Yii::t('app', 'menuManage', array(), 'i18n')), 'url'=>array('admin')),
);
?>

<h3><?php echo utf8_encode(Yii::t('app', 'breadView', array(), 'i18n')); ?> ErpnetConfig #<?php echo $model->empresa; ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'empresa',
		'mostra_lang',
	),
)); ?>
