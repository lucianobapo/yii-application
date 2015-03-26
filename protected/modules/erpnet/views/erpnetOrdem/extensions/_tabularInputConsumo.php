
<td>
	<?php echo CHtml::activeDropDownList($model,"[$index]id_produto",ErpnetProduto::getItens(),array('class'=>'input-xlarge')); ?>
	<?php echo CHtml::error($model,"[$index]id_produto"); ?>
	</td>
	<?php if ($model->getScenario()=='compra'): ?>
	<td>
	<?php echo CHtml::activeTextField($model,"[$index]data_entrega",array('class'=>'input-medium','value'=>date('d/m/Y'))); ?>
	<?php echo CHtml::error($model,"[$index]data_entrega"); ?>
	</td>
	<?php endif; ?>
<td>
	<?php echo CHtml::activeTextField($model,"[$index]quantidade",array('class'=>'input-small')); ?>
	<?php echo CHtml::error($model,"[$index]quantidade"); ?>
	</td>
<td>
	<?php echo CHtml:: activeTextField($model,"[$index]valor",array('class'=>'input-small')); ?>
	<?php echo CHtml::error($model,"[$index]valor"); ?>
	</td>
<td>
	<?php echo CHtml::activeDropDownList($model,"[$index]moeda",Yii::app()->params['moedas'],array('class'=>'input-small')); ?>
	<?php echo CHtml::error($model,"[$index]moeda"); ?>
	
	<?php echo CHtml::activeHiddenField($model,"[$index]empresa",array('value'=>Yii::app()->user->empresa)); ?>
	<?php echo CHtml::activeHiddenField($model,"[$index]usuario",array('value'=>Yii::app()->user->name)); ?>
	<?php //echo CHtml::activeHiddenField($model,"[$index]tipo",array('value'=>'producao')); ?>
</td>