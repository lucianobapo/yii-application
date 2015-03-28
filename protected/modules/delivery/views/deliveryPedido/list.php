<?php
/* @var $this DeliveryPedidoController */
/* @var $model DeliveryPedido */

$this->breadcrumbs=array();

$this->menu=array();

/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#delivery-pedido-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/
//echo YiiBase::getPathOfAlias('app.components');
?>

<h1 class="st1 vt1"><?php echo Helpers::t('appUi','{empresa} - Lista de Pedidos',array('{empresa}'=>Yii::app()->name)); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'delivery-pedido-grid',
	'htmlOptions'=>array('class'=>'table-responsive'),
	'itemsCssClass'=>'table table-striped table-hover ',
	'dataProvider'=>$model->search(),
		//'updateSelector'=>"{page}",
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		array(
			'name'=>'id',
			'header'=>Helpers::t('app', 'Nº'),
			'type' => 'text',
			'value'=>'$data->id',
			'sortable'=>false,

			//'headerHtmlOptions'=>array('style'=>'width: 78px;'),
		),
		array(
			'name'=>'data_termino',
			'header'=>Helpers::t('app', 'Data'),
			'type' => 'text',
			'value'=>'Yii::app()->dateFormatter->formatDateTime($data->data_termino,"medium",null)',
			//'headerHtmlOptions'=>array('style'=>'width: 89px;'),
			'sortable'=>false,
		),
		array(
			'name'=>'valor',
			'header'=>Helpers::t('app', 'Valor'),
			'type' => 'text',
			'value'=>'CHtml::encode(Yii::app()->numberFormatter->formatCurrency($data->valor,"R$"))',
			//'headerHtmlOptions'=>array('style'=>'width: 68px;'),
			'sortable'=>false,
		),

		array(
			'name'=>'pagamento',
			'header'=>Helpers::t('app', 'Pagamento'),
			'type' => 'text',
			'value'=>'(Yii::app()->params["pagamento"][$data->pagamento])',
			//'headerHtmlOptions'=>array('style'=>'width: 95px;'),
			'sortable'=>false,
		),
        /*
		array(
			'name'=>'obs',
			'header'=>Helpers::t('app', 'Troco'),
			'type' => 'text',
			'value'=>'CHtml::encode(Yii::app()->numberFormatter->formatCurrency($data->obs,"R$"))',
			//'headerHtmlOptions'=>array('style'=>'width: 95px;'),
			'sortable'=>false,
		),
		array(
			//'name'=>'id',
			'header'=>Helpers::t('app', 'CEP'),
			'type' => 'html',
			//'value'=>'(($entrega=DeliveryEntrega::getEntrega($data->id))===null)?null:$entrega->cep',
            'value'=>'CHtml::encode(DeliveryPedido::getEndereco($data->id))',
			//'value'=>'',
			'sortable'=>false,
		),*/
		array(
			//'name'=>'id',
			'header'=>Helpers::t('app', 'Produtos'),
			'type' => 'html',
			'value'=>'CHtml::encode(DeliveryPedido::getProdutos($data->id))',
			'sortable'=>false,
		),

			/*
		array(
			//'name'=>'id',
			'header'=>Helpers::t('app', 'Endere�o'),
			'type' => 'html',
			'value'=>'CHtml::encode(DeliveryEntrega::getEntrega($data->id)->endereco)'
		),*/
		//'empresa',
		//'data_criacao',
		//'usuario',
		//'data_inicio',
		//'data_termino',
		/*
		'id_produto',
		'id_wbs',
		'id_wbs_destino',
		'id_cliente',
		'turno',
		'quantidade',
		'valor',
		'moeda',
		'tipo',
		'pagamento',
		'texto_header',
		'referencia',
		'obs',
		'status_fechado',
		*/
		array(
			'class'=>'CButtonColumn',
            'header'=>Helpers::t('app', 'Ações'),
			//'viewDialogEnabled'=>false,
			'template' => '{redo}{update}{delete}',
			'buttons'=>array(
				'delete'=>array(
					'visible'=>'DeliveryPedido::isOpen($data->id)',
					'url' => 'Yii::app()->createUrl(Helpers::getModuleName()."/deliveryPedido/cancel", array("id"=>$data->id))',
					'label' => '<i class="fa fa-times spacing-borders"></i>',//Helpers::t('app', 'Cancelar Pedido'),
					'options'=> array('title'=>Helpers::t('app', 'Cancelar Pedido')),
					'imageUrl' => false,
				),
				'update'=>array(
					'visible'=>'DeliveryPedido::isOpen($data->id)',
					'label' => '<i class="fa fa-pencil spacing-borders"></i>',//Helpers::t('app', 'Revisar Pedido'),
					'imageUrl' => false,
					'options'=> array('title'=>Helpers::t('app', 'Revisar Pedido')),
				),
				'redo'=>array(
					'visible'=>'(!DeliveryPedido::isOpen($data->id))',
					'label' => '<i class="fa fa-reply spacing-borders"></i>',//Helpers::t('app', 'Repetir Pedido'),
					'imageUrl' => false,//Yii::app()->baseUrl . '/images/redo.png',
					'options'=> array('title'=>Helpers::t('app', 'Repetir Pedido')),
					'url' => 'Yii::app()->createUrl(Helpers::getModuleName()."/deliveryPedido/create", array("id"=>$data->id))',
				),
			),
			
		),
	),
)); 

?>
