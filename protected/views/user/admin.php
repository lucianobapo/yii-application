<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	Yii::t('app', 'breadManage', array(), 'i18n'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'menuCreate', array(), 'i18n'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3><?php echo Yii::t('app', 'breadManage', array(), 'i18n'); ?> Users</h3>

<p><?php echo Yii::t('app', 'appFormLabel3', array(), 'i18n'); ?></p>

<?php echo CHtml::link(Yii::t('app', 'appFormLabel4', array(), 'i18n'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
		//'password',
		'email',
		'empresa',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
