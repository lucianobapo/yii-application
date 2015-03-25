<?php
/* @var $this DeliveryEnderecoController */
/* @var $model DeliveryEndereco */

$this->breadcrumbs=array();

$this->menu=array();

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#delivery-endereco-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Helpers::t('app', 'breadManage'); ?> Delivery Enderecos</h1>

<p><?php echo Helpers::t('app', 'appFormLabel3'); ?> </p>

<?php echo CHtml::link(Helpers::t('app', 'appFormLabel4'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'delivery-endereco-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'empresa',
		'data_criacao',
		'data_update',
		'id_entidade',
		'cep',
		/*
		'logradouro',
		'bairro',
		'cidade',
		'estado',
		'pais',
		'complemento',
		'obs',
		*/
		array(
			'class'=>'EJuiDlgsColumn',
			'viewDialogEnabled'=>false,
			'buttons'=>array(
				'view'=>array(
					'url'=>'Yii::app()->createUrl("view", array("id"=>$data->id,"asDialog"=>1))',
					'options'=>array(
						'ajax'=>array(
							'type'=>'POST',
							// ajax post will use 'url' specified above
							'url'=>"js:$(this).attr('href')",
							'update'=>'#id_view',
						),
					),
				),
			),
			'updateDialog'=>array(
				'controllerRoute' => 'update', //=default
				'actionParams' => array('id' => '$data->primaryKey'), //=default
				'dialogTitle' => Helpers::t('app', 'dialogUpdate'),
				'dialogWidth' => 470, //override the value from the dialog config
				'dialogHeight' => 350,
				'iframeHtmlOptions' => array('width' => '430', 'height' => '280'),
			),
		),
	),
)); 

//the dialog
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
'id'=>'dlg-address-view',
'options'=>array(
    'title'=>Helpers::t('app', 'dialogView'),
    'autoOpen'=>false, //important!
    'modal'=>false,
    'width'=>400,
    'height'=>250,
),
));
echo '<div id="id_view"></div>';
$this->endWidget();
?>
