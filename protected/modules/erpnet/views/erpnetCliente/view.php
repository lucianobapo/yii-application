<?php
/* @var $this ErpnetClienteController */
/* @var $model ErpnetCliente */

$this->breadcrumbs=array(
	'Erpnet Clientes'=>array('admin'),
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

<h3><?php echo utf8_encode(Yii::t('app', 'breadView', array(), 'i18n')); ?> <?php echo utf8_encode(Yii::t('erpnetUi', 'viewCreateClientesTitle', array(), 'i18n')); ?> #<?php echo $model->id; ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		//'empresa',
		'cnpj',
		'nome',
		'email',
		
		'endereco',
		'telefone',
		'contato',
		'obs',
	),
)); ?>
