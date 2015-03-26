<?php
/* @var $this ErpnetProdutoController */
/* @var $model ErpnetProduto */

$this->breadcrumbs=array(
	'Produtos'=>array('admin'),
	utf8_encode(Yii::t('app', 'breadCreate', array(), 'i18n')),
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>utf8_encode(Yii::t('app', 'menuManage', array(), 'i18n')), 'url'=>array('admin')),
);
?>

<h3><?php echo utf8_encode(Yii::t('app', 'breadCreate', array(), 'i18n'));?> Produto</h3>

<?php $this->renderPartial('_form', array('model'=>$model,'itens_descricao'=>$itens_descricao)); ?>