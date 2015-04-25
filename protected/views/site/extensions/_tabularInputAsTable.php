<td>
	<?php echo CHtml::activeTextField($model,"[$index]num_ordem",array('class'=>'span2')); ?>
	<?php echo CHtml::activeTextField($model,"[$index]data_emissao",array('class'=>'span2')); ?>
	<?php echo CHtml::activeTextField($model,"[$index]moeda",array('class'=>'span1')); ?>
	<?php echo CHtml::activeTextField($model,"[$index]conversao_brl",array('class'=>'span2')); ?>
	<?php echo CHtml::activeTextField($model,"[$index]incoterm",array('class'=>'span1')); ?>
	<?php echo CHtml::activeTextField($model,"[$index]incoterm_local",array('class'=>'span2')); ?>

<!-- 
	<?php echo CHtml::error($model,"[$index]num_ordem"); ?>
	<?php echo CHtml::error($model,"[$index]data_emissao"); ?>
	<?php echo CHtml::error($model,"[$index]moeda"); ?>
	<?php echo CHtml::error($model,"[$index]conversao_brl"); ?>
	<?php echo CHtml::error($model,"[$index]incoterm"); ?>
	<?php echo CHtml::error($model,"[$index]incoterm_local"); ?>

 -->
</td>