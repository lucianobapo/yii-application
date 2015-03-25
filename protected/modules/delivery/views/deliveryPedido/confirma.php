<?php
/* @var $this DeliveryEntregaController */
/* @var $model DeliveryEntrega */

$this->breadcrumbs=array();

$this->menu=array();

?>

<h1><?php echo Helpers::t('appUi','{empresa} - Confirmar Entrega - Pedido nº{numero}',array('{numero}'=>$id,'{empresa}'=>Yii::app()->name)); ?></h1>

<?php $this->widget('ext.widgets.mostrarProdutos.MostrarProdutosOrdem', array(
				'id'=>$id,
				//'modelItem'=>$modelItem,
				//'form'=>$form,
		));?>
<div class="row-fluid">
	<div class="span6">
		<h4><?php echo Helpers::t('appUi', 'Endereço de Entrega: ')?></h4>
		<ul class="list-blog-roll">
			<li><?php echo Helpers::t('appUi', 'CEP: ').$parceiro->cep; ?></li>
			<li><?php echo Helpers::t('appUi', 'Cidade: ').$parceiro->cidade.'/'.$parceiro->estado; ?></li>
			<li><?php echo Helpers::t('appUi', 'Bairro: ').$parceiro->custom3; ?></li>
			<li><?php echo Helpers::t('appUi', 'Endereço: ').$parceiro->endereco.', '.$parceiro->custom4; ?></li>
		</ul>
		<!-- <p><a href="#"><?php echo Helpers::t('appUi', 'Outro endereço')?></a></p> -->

	</div>
	<div class="sb16">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'delivery-entrega-form',
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
				'confirma'=>Helpers::t('appUi','Este pedido ainda não foi enviado!',array(),'i18n',null,false),
			),
		)); ?>

		<div class="buttons">
			<a href="<?php echo $this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/cancel', array("id"=>$id) ); ?>"
			   class="btn btn-small btn-danger" click-once="<?php echo Helpers::t('app', 'Carregando...'); ?>"><?php echo Helpers::t('appUi', 'Cancelar Pedido'); ?></a>
			<a href="<?php echo $this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/update', array("id"=>$id) ); ?>"
			   class="btn btn-small btn-warning" click-once="<?php echo Helpers::t('app', 'Carregando...'); ?>"><?php echo Helpers::t('appUi', 'Revisar Pedido'); ?></a>
			<?php echo CHtml::submitButton(Helpers::t('appUi', 'Confirmar Entrega'),array('class'=>'btn btn-large btn-success','click-once'=>Helpers::t('app', 'Carregando...'))); ?>
			<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
			<?php echo $form->hiddenField($model,'usuario',array('value'=>Yii::app()->user->social_identifier)) ?>
			<?php echo $form->hiddenField($model,'id_ordem',array('value'=>$id)) ?>
			<?php echo $form->hiddenField($model,'cep',array('value'=>$parceiro->cep)) ?>
			<?php echo $form->hiddenField($model,'endereco',array('value'=>$parceiro->endereco)) ?>
		</div>

		<?php $this->endWidget(); ?>

	</div><!-- form -->

</div>