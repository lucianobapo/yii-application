<?php
/* @var $this ErpnetWbsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Erpnet Wbs',
);

$this->menu=array(
	array('label'=>Yii::t('app', 'menuCreate', array(), 'i18n'), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'menuManage', array(), 'i18n'), 'url'=>array('admin')),
);
?>

<h3>Erpnet Wbs</h3>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
