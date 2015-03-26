<?php
/* @var $this ErpnetProdutoController */
/* @var $model ErpnetProduto */

$this->breadcrumbs=array(
	'Erpnet Produtos'=>array('index'),
	$model->id=>array('admin'),
	utf8_encode(Yii::t('app', 'breadUpdate', array(), 'i18n')),
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>utf8_encode(Yii::t('app', 'menuCreate', array(), 'i18n')), 'url'=>array('create')),
	//array('label'=>Yii::t('app', 'menuView', array(), 'i18n'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>utf8_encode(Yii::t('app', 'menuManage', array(), 'i18n')), 'url'=>array('admin')),
);
?>

<h3><?php echo utf8_encode(Yii::t('app', 'breadUpdate', array(), 'i18n')); ?> Produto <?php echo $model->id; ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model,'itens_descricao'=>$itens_descricao,)); ?>