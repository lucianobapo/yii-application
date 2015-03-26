<?php
/* @var $this ErpnetProdutoController */
/* @var $model ErpnetProduto */

$this->breadcrumbs=array(
	utf8_encode(Yii::t('erpnetUi', 'breadProdutos', array(), 'i18n'))=>array('admin'),
	utf8_encode(Yii::t('app', 'breadManage', array(), 'i18n')),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>utf8_encode(Yii::t('app', 'menuCreate', array(), 'i18n')), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#erpnet-produto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3><?php echo utf8_encode(Yii::t('erpnetUi', 'viewProdutosTitle', array(), 'i18n')); ?></h3>

<p><?php echo utf8_encode(Yii::t('app', 'appFormLabel3', array(), 'i18n')); ?> </p>

<?php echo CHtml::link(utf8_encode(Yii::t('app', 'appFormLabel4', array(), 'i18n')),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'erpnet-produto-grid',
	'itemsCssClass'=>'table table-hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		//'empresa',
		
		'descricao',
		'cod_fiscal',
		'cod_barra',
		'uom',
		'valor',
		'valor_venda',
		'valor_promocao',
		array(
			'class'=>'EJuiDlgsColumn',
			'viewDialogEnabled'=>false,
			'template' => '{update}{delete}{ativar}',
			//'deleteConfirmation'=>'teste',
			'buttons'=>array(
				
				'delete'=>array(
					'visible'=>'ErpnetProduto::model()->findByPk($data->id)->ativado',
					'label' => 'Desativar',
				),
				'ativar'=>array(
					'visible'=>'(!ErpnetProduto::model()->findByPk($data->id)->ativado)',
					'label' => 'Ativar', // text label of the button
					'url' => 'Yii::app()->createUrl(Helpers::getModuleName()."/erpnetProduto/ativar", array("id"=>$data->id))', //Your URL According to your wish
					'imageUrl' => Yii::app()->baseUrl . '/images/pdf.png', // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
					//'options'=>array('options'=>array("target"=>"_new")),
				),
			),
			'updateDialog'=>array(
				'controllerRoute' => Controller::getModuleName().'/erpnetProduto/update', //=default
				'actionParams' => array('id' => '$data->primaryKey'), //=default
				'dialogTitle' => utf8_encode(Yii::t('app', 'dialogUpdate', array(), 'i18n')),
				'dialogWidth' => 810, //override the value from the dialog config
				'dialogHeight' => 350,
				'iframeHtmlOptions' => array('width' => '770', 'height' => '280'),
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
