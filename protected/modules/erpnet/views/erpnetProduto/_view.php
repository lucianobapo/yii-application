<?php
/* @var $this ErpnetProdutoController */
/* @var $data ErpnetProduto */
?>


<b><?php echo CHtml::encode($data->descricao);?></b> - <?php 
//Yii::app()->numberFormatter->formatCurrency($data->valor)
echo CHtml::encode(Yii::app()->numberFormatter->formatCurrency($data->valor,'R$'));
?> <?php //echo CHtml::encode($data->moeda);?>
<br>
<i><?php echo CHtml::encode($data->obs); ?></i><br>
<!--
<div class="view">
	<b><?php //echo CHtml::encode($data->getAttributeLabel('descricao')); ?>:</b>
	<?php //echo CHtml::encode($data->descricao);?> - <?php //echo CHtml::encode($data->valor);?> <?php //echo CHtml::encode($data->moeda);?>
	 <br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('valor')); ?>:</b>
	<?php //echo CHtml::encode($data->valor); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('cod_fiscal')); ?>:</b>
	<?php //echo CHtml::encode($data->cod_fiscal); ?>
	<br /> 

	<b><?php //echo CHtml::encode($data->getAttributeLabel('obs')); ?>:</b>
	<?php //echo CHtml::encode($data->obs); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('uom')); ?>:</b>
	<?php //echo CHtml::encode($data->uom); ?>
	<br /></div>
-->

