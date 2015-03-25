<?php
/* @var $this DeliveryPedidoController */
/* @var $data DeliveryPedido */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empresa')); ?>:</b>
	<?php echo CHtml::encode($data->empresa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_criacao')); ?>:</b>
	<?php echo CHtml::encode($data->data_criacao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario')); ?>:</b>
	<?php echo CHtml::encode($data->usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_inicio')); ?>:</b>
	<?php echo CHtml::encode($data->data_inicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_termino')); ?>:</b>
	<?php echo CHtml::encode($data->data_termino); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_produto')); ?>:</b>
	<?php echo CHtml::encode($data->id_produto); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_wbs')); ?>:</b>
	<?php echo CHtml::encode($data->id_wbs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_wbs_destino')); ?>:</b>
	<?php echo CHtml::encode($data->id_wbs_destino); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->id_cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('turno')); ?>:</b>
	<?php echo CHtml::encode($data->turno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantidade')); ?>:</b>
	<?php echo CHtml::encode($data->quantidade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor')); ?>:</b>
	<?php echo CHtml::encode($data->valor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('moeda')); ?>:</b>
	<?php echo CHtml::encode($data->moeda); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pagamento')); ?>:</b>
	<?php echo CHtml::encode($data->pagamento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('texto_header')); ?>:</b>
	<?php echo CHtml::encode($data->texto_header); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('referencia')); ?>:</b>
	<?php echo CHtml::encode($data->referencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('obs')); ?>:</b>
	<?php echo CHtml::encode($data->obs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_fechado')); ?>:</b>
	<?php echo CHtml::encode($data->status_fechado); ?>
	<br />

	*/ ?>

</div>