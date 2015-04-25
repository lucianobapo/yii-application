<?php
/* @var $this ErpnetQuestionarioController */
/* @var $model ErpnetQuestionario */

$this->breadcrumbs=array(
	'Erpnet Questionarios'=>array('admin'),
	$model->id,
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>utf8_encode(Yii::t('app', 'menuCreate', array(), 'i18n')), 'url'=>array('create')),
	//array('label'=>Yii::t('app', 'menuUpdate', array(), 'i18n'), 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>Yii::t('app', 'menuDelete', array(), 'i18n'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>utf8_encode(Yii::t('app', 'menuManage', array(), 'i18n')), 'url'=>array('admin')),
);
?>

<h3><?php echo utf8_encode(Yii::t('app', 'breadView', array(), 'i18n')); ?> ErpnetQuestionario #<?php echo $model->id; ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'empresa',
		'campo01',
		'campo02',
		'campo03',
		'campo04',
		'campo05',
		'campo06',
		'campo07',
		'campo08',
		'campo09',
		'campo10',
		'campo11',
		'campo12',
		'campo13',
		'campo14',
		'campo15',
	),
)); ?>
