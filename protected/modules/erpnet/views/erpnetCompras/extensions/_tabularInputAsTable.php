<td>
	<?php echo CHtml::activeTextField($model,"[$index]num_ordem",array()); ?>
	<?php echo CHtml::error($model,"[$index]num_ordem"); ?>
	</td>
<td>
	<?php echo CHtml::activeTextField($model,"[$index]data_emissao",array()); ?>
	<?php echo CHtml::error($model,"[$index]data_emissao"); ?>
	</td>
<td>
	<?php echo CHtml::activeTextField($model,"[$index]moeda",array()); ?>
	<?php echo CHtml::error($model,"[$index]moeda"); ?>
	</td>
<td>
	<?php echo CHtml::activeTextField($model,"[$index]conversao_brl",array()); ?>
	<?php echo CHtml::error($model,"[$index]conversao_brl"); ?>
	</td>
<td>
	<?php echo CHtml::activeTextField($model,"[$index]incoterm",array()); ?>
	<?php echo CHtml::error($model,"[$index]incoterm"); ?>
	</td>
<td>
	<?php echo CHtml::activeTextField($model,"[$index]incoterm_local",array()); ?>
	<?php echo CHtml::error($model,"[$index]incoterm_local"); ?>
</td>