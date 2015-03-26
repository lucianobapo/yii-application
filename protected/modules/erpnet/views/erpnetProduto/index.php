<?php
/* @var $this ErpnetProdutoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	utf8_encode(Yii::t('erpnetUi', 'viewProdutosTitle', array(), 'i18n')),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'menuCreate', array(), 'i18n'), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'menuManage', array(), 'i18n'), 'url'=>array('admin')),
);
?>

<h3><?php echo utf8_encode(Yii::t('erpnetUi', 'viewProdutosTitle', array(), 'i18n')); ?></h3>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
