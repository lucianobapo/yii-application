<?php
/* @var $this ErpnetComprasController */
/* @var $data ErpnetCompras */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empresa')); ?>:</b>
	<?php echo CHtml::encode($data->empresa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_ordem')); ?>:</b>
	<?php echo CHtml::encode($data->num_ordem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_criacao')); ?>:</b>
	<?php echo CHtml::encode($data->data_criacao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_emissao')); ?>:</b>
	<?php echo CHtml::encode($data->data_emissao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('moeda')); ?>:</b>
	<?php echo CHtml::encode($data->moeda); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conversao_brl')); ?>:</b>
	<?php echo CHtml::encode($data->conversao_brl); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('incoterm')); ?>:</b>
	<?php echo CHtml::encode($data->incoterm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('incoterm_local')); ?>:</b>
	<?php echo CHtml::encode($data->incoterm_local); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('texto')); ?>:</b>
	<?php echo CHtml::encode($data->texto); ?>
	<br />

	*/ ?>

</div>