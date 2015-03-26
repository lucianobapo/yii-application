<?php
/* @var $this ErpnetOrdemController */
/* @var $data ErpnetOrdem */
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_termino')); ?>:</b>
	<?php echo CHtml::encode($data->data_termino); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_produto')); ?>:</b>
	<?php echo CHtml::encode($data->id_produto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_wbs')); ?>:</b>
	<?php echo CHtml::encode($data->id_wbs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('turno')); ?>:</b>
	<?php echo CHtml::encode($data->turno); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('quantidade')); ?>:</b>
	<?php echo CHtml::encode($data->quantidade); ?>
	<br />

	*/ ?>

</div>