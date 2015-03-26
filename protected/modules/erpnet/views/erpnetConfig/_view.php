<?php
/* @var $this ErpnetConfigController */
/* @var $data ErpnetConfig */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('empresa')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->empresa), array('view', 'id'=>$data->empresa)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mostra_lang')); ?>:</b>
	<?php echo CHtml::encode($data->mostra_lang); ?>
	<br />


</div>