<?php
/* @var $this DeliveryPedidoController */
/* @var $model DeliveryPedido */
/* @var string $action */

$this->breadcrumbs=array();
$this->menu=array();


?>

<?php
//echo '<pre>'.CVarDumper::dumpAsString($model).'</pre>';
$this->renderPartial('angularDeliveryPedido', array('modelOrdem'=>$model,'modelItem'=>$modelItem,)); ?>

<article>
	<?php if(Yii::app()->user->hasFlash('erro')): ?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php echo Yii::app()->user->getFlash('erro'); ?>
		</div>
	<?php endif; ?>

	<?php if(Yii::app()->user->hasFlash('success')): ?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
	<?php endif; ?>

	<?php if(Yii::app()->user->hasFlash('alert')): ?>
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo Yii::app()->user->getFlash('alert'); ?>
		</div>
	<?php endif; ?>

	<?php if(Yii::app()->user->hasFlash('sugestao')): ?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo Yii::app()->user->getFlash('sugestao'); ?>
		</div>
	<?php else: ?>

	<!-- <carrinho></carrinho> -->
</article>

<div class="sb16">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'delivery-pedido-sugestao-form',
			'action'=>$action,
			//'focus'=>'input:visible:enabled:first',
			'htmlOptions'=> array(
				//'encode'=>false,
				//'ng-controller'=>'PedidoController as pedidoCtrl',
				//'ng-submit'=>'pedidoForm.$valid && pedidoCtrl.addPedido()',
				//'name'=>'pedidoForm',
				'novalidate' => 'novalidate',
				//'class'=>'verificaFormEnviar',
			),


			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
		));
		//if (isset($debug)) echo '<pre>'.CVarDumper::dumpAsString($debug).'</pre>';

		?>

	<h1><?php echo isset($id)?Helpers::t('appUi','{empresa} - Crie seu pedido com base no nº{numero}',array('{numero}'=>$id,'{empresa}'=>Yii::app()->name)):Helpers::t('appUi','{empresa} - Crie seu pedido',array('{empresa}'=>Yii::app()->name)); ?></h1>

	<div class="sb18">
		<?php
			echo CHtml::textField("sugestao",'',array('class'=>'sb19','maxlength'=>255,'placeholder'=>Helpers::t('appUi', 'Digite sua sugestão de produtos',null,null,null,false)));
			echo CHtml::submitButton(Helpers::t('appUi', 'Enviar Sugestão',array(),'i18n',null,false),array('class'=>'btn btn-info btn-sm','click-once'=>Helpers::t('app', 'Carregando...')));
		?>
	</div>
	<?php $this->endWidget(); ?>

	<?php endif; ?>

</div>

<?php
//CActiveForm::
$form=$this->beginWidget('EActiveForm', array(
	'id'=>'delivery-pedido-form',
	//'enableClientValidation'=>true,
	'action'=>$action,
	//'action'=>null,
	//'htmlOptions'=> array('ng-controller'=>'PedidoController as pedidoCtrl','name'=>'pedidoForm',),
	//'focus'=>'input:visible:enabled:first',

	'htmlOptions'=> array(
		//'encode'=>false,
		//'ng-controller'=>'PedidoController as pedidoCtrl',
		//'ng-submit'=>'pedidoForm.$valid && pedidoCtrl.addPedido()',
		//'name'=>'pedidoForm',
		'novalidate' => 'novalidate',
		//'class'=>'verifica',
		'verifica'=>Helpers::t('appUi','Este pedido ainda não foi enviado!',array(),'i18n',null,false),
	),

	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));
?>

<?php
	$errors=array();
	if (isset($model)) array_push($errors,$model);
	if (isset($modelItem)) foreach ($modelItem as $key=>$value) array_push($errors,$value);
	echo $form->errorSummary(
		$errors,
		'<button type="button" class="close" data-dismiss="alert">&times;</button>'.
		'<p>'.Yii::t('yii','Please fix the following input errors:').'</p>',
		null,
		array('class'=>'alert alert-danger')
	);
?>

<create-product-panel>
	<?php $this->renderPartial('/default/create-product-panel',array('modelOrdem'=>$model,'form'=>$form)); ?>
</create-product-panel>

<?php $this->endWidget(); ?>
