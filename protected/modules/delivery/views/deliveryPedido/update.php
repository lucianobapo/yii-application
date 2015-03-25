<?php
/* @var $this DeliveryPedidoController */
/* @var $model DeliveryPedido */

$this->breadcrumbs=array();
$this->menu=array();
?>

<?php $this->renderPartial('angularDeliveryPedido', array('modelOrdem'=>$model,'modelItem'=>$modelItem,)); ?>

	<h1 class="st1 vt1"><?php echo Helpers::t('appUi','{empresa} - Revisar Pedido nº{pedido}',array('{empresa}'=>Yii::app()->name,'{pedido}'=>$model->id)); ?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'delivery-pedido-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=> array(
		//'encode'=>false,
		//'ng-controller'=>'PedidoController as pedidoCtrl',
		//'ng-submit'=>'pedidoForm.$valid && pedidoCtrl.addPedido()',
		//'name'=>'pedidoForm',
		'novalidate' => 'novalidate',
		//'class'=>'verifica',
		'verifica'=>Helpers::t('appUi','Este pedido ainda não foi enviado!',array(),'i18n',null,false),
	),
)); ?>

<?php if (isset($model)) echo $form->errorSummary($model); ?>
<?php if (isset($modelItem)) foreach ($modelItem as $key=>$value) echo $form->errorSummary($value); ?>

<create-product-panel>
	<?php $this->renderPartial('/default/create-product-panel',array('modelOrdem'=>$model,'form'=>$form)); ?>
</create-product-panel>


<?php $this->endWidget(); ?>