<td>
	<?php echo CHtml::activeDropDownList($model,"[$index]id_produto",ErpnetProduto::getItens(),array('class'=>'input-xlarge','empty'=>'--Selecione--')); ?>
	<?php //echo CHtml::error($model,"[$index]id_produto"); ?>
</td>

<td>
	<?php echo CHtml::activeTextField($model,"[$index]quantidade",array('class'=>'input-small')); ?>
	<?php //echo CHtml::error($model,"[$index]quantidade"); ?>
</td>

<td>
	<?php echo CHtml:: activeTextField($model,"[$index]valor",array('class'=>'input-small')); ?>
	<?php //echo CHtml::error($model,"[$index]valor"); ?>
</td>

<td>
	<?php if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->outras_moedas)
			echo CHtml::activeDropDownList($model,"[$index]moeda",Yii::app()->params['moedas'],array('class'=>'input-medium')); ?>

	
	<?php echo CHtml::activeHiddenField($model,"[$index]empresa",array('value'=>Yii::app()->user->empresa)); ?>
	<?php echo CHtml::activeHiddenField($model,"[$index]usuario",array('value'=>Yii::app()->user->name)); ?>
	<?php echo CHtml::activeHiddenField($model,"[$index]id",array()); ?>
	<?php //echo CHtml::activeHiddenField($model,"[$index]tipo",array('value'=>'producao')); ?>
</td>