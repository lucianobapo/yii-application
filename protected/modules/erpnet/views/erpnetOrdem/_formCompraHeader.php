<?php
/* @var $this ErpnetOrdemController */
/* @var $model ErpnetOrdem */
?>

<?php
	$this->breadcrumbs[Helpers::t('erpnetUi', 'breadOrdemCompra')]=array('createCompra');
	array_push($this->breadcrumbs, Helpers::t('app', 'breadCreate'));
	
	$this->menu=array(
			//array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
			array('label'=>Helpers::t('app', 'menuCreate'), 'url'=>array('createCompra')),
	);
?>

<h3><?php echo Helpers::t('erpnetUi', 'viewCreateOrdemCompraTitle'); ?></h3>
