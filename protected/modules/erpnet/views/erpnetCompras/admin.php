<?php
/* @var $this ErpnetComprasController */
/* @var $model ErpnetCompras */

$this->breadcrumbs=array(
	'Ordens de Compra'=>array('admin'),
	utf8_encode(Yii::t('app', 'breadManage', array(), 'i18n')),
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>utf8_encode(Yii::t('app', 'menuCreate', array(), 'i18n')), 'url'=>array('create')),
	array('label'=>utf8_encode(Yii::t('app', 'menuCreate', array(), 'i18n')), 'url'=>array('batchCreate')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#erpnet-compras-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3><?php echo utf8_encode(Yii::t('erpnet', 'Ordens de Compra', array(), 'i18n')); ?></h3>

<p>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"Lista de Compras",
		));		
	?>
  	<?php $this->widget('zii.widgets.grid.CGridView', array(
			/*'type'=>'striped bordered condensed',*/
  			'id'=>'erpnet-compras-grid2',
  			'filter'=>$model,
  			'itemsCssClass'=>'table table-hover',
			'dataProvider'=>$model->search(),
			'template'=>"{items}",
			'columns'=>array(
				array('name'=>'num_ordem'),
				//array('name'=>'data_emissao', 'header'=>'Data'),
				array(
					'name'=>'data_emissao',
					//'header'=>'Data',
					'value'=>'Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($data->data_emissao, \'yyyy-MM-dd\'),\'medium\',null)',
				),
				array('name'=>'moeda'),
				array('name'=>'incoterm', 'type'=>'raw'),
				//array('name'=>'usage', 'header'=>'Usage', 'type'=>'raw'),
				array(
					'class'=>'EJuiDlgsColumn',
					'viewDialogEnabled'=>false,
					'buttons'=>array(
						'view'=>array(
							'url'=>'Yii::app()->createUrl(Controller::getModuleName()."/erpnetCompras/view", array("id"=>$data->id,"asDialog"=>1))',
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
						'controllerRoute' => Controller::getModuleName().'/erpnetCompras/update', //=default
						'actionParams' => array('id' => '$data->primaryKey'), //=default
						'dialogTitle' => utf8_encode(Yii::t('app', 'dialogUpdate', array(), 'i18n')),
						'dialogWidth' => 470, //override the value from the dialog config
						'dialogHeight' => 350,
						'iframeHtmlOptions' => array('width' => '430', 'height' => '280'),
					),
				),
				
			),
		)); ?>
		
	<?php $this->endWidget();?>
  
  </p>

<p><?php echo utf8_encode(Yii::t('app', 'appFormLabel3', array(), 'i18n')); ?> </p>

<?php echo CHtml::link(utf8_encode(Yii::t('app', 'appFormLabel4', array(), 'i18n')),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>

</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'erpnet-compras-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'empresa',
		'num_ordem',
		'data_criacao',
		'data_emissao',
		'moeda',

		'conversao_brl',
		'incoterm',
		'incoterm_local',
		'texto',

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
				'dialogTitle' => utf8_encode(Yii::t('app', 'dialogUpdate', array(), 'i18n')),
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
    'title'=>utf8_encode(Yii::t('app', 'dialogView', array(), 'i18n')),
    'autoOpen'=>false, //important!
    'modal'=>false,
    'width'=>400,
    'height'=>250,
),
));
echo '<div id="id_view"></div>';
$this->endWidget();
?>
