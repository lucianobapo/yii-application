<?php
/* @var $this ErpnetQuestionarioController */
/* @var $data ErpnetQuestionario */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empresa')); ?>:</b>
	<?php echo CHtml::encode($data->empresa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo01')); ?>:</b>
	<?php echo CHtml::encode($data->campo01); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo02')); ?>:</b>
	<?php echo CHtml::encode($data->campo02); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo03')); ?>:</b>
	<?php echo CHtml::encode($data->campo03); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo04')); ?>:</b>
	<?php echo CHtml::encode($data->campo04); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo05')); ?>:</b>
	<?php echo CHtml::encode($data->campo05); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('campo06')); ?>:</b>
	<?php echo CHtml::encode($data->campo06); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo07')); ?>:</b>
	<?php echo CHtml::encode($data->campo07); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo08')); ?>:</b>
	<?php echo CHtml::encode($data->campo08); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo09')); ?>:</b>
	<?php echo CHtml::encode($data->campo09); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo10')); ?>:</b>
	<?php echo CHtml::encode($data->campo10); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo11')); ?>:</b>
	<?php echo CHtml::encode($data->campo11); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo12')); ?>:</b>
	<?php echo CHtml::encode($data->campo12); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo13')); ?>:</b>
	<?php echo CHtml::encode($data->campo13); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo14')); ?>:</b>
	<?php echo CHtml::encode($data->campo14); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campo15')); ?>:</b>
	<?php echo CHtml::encode($data->campo15); ?>
	<br />

	*/ ?>

</div>