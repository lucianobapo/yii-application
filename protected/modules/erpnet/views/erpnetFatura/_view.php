<?php
/* @var $this ErpnetFaturaController */
/* @var $data ErpnetFatura */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empresa')); ?>:</b>
	<?php echo CHtml::encode($data->empresa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_produto')); ?>:</b>
	<?php echo CHtml::encode($data->id_produto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_ordem')); ?>:</b>
	<?php echo CHtml::encode($data->id_ordem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_wbs')); ?>:</b>
	<?php echo CHtml::encode($data->id_wbs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descricao_wbs')); ?>:</b>
	<?php echo CHtml::encode($data->descricao_wbs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_criacao')); ?>:</b>
	<?php echo CHtml::encode($data->data_criacao); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('data_movimento')); ?>:</b>
	<?php echo CHtml::encode($data->data_movimento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario')); ?>:</b>
	<?php echo CHtml::encode($data->usuario); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('turno')); ?>:</b>
	<?php echo CHtml::encode($data->turno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />

	*/ ?>

</div>