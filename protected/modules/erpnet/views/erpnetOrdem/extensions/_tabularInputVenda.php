<td>
	<?php
	/*Yii::app()->clientScript->registerScript('jquery-priceformat', "
$('input[id*=_valor]').priceFormat({
    prefix: 'R$ ',
    centsSeparator: ',',
    thousandsSeparator: '.',
    clearPrefix: true
});
");*/
	
	
	//*
	if ( (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->search_produto_venda)&&(!Yii::app ()->request->isAjaxRequest) ) {
		$attribute="[$index]id_produto";
		$htmlOptions=array();
		CHtml::resolveNameID($model, $attribute, $htmlOptions);
		$id=$htmlOptions['id'];
		$options=CJavaScript::encode(array('minLength'=>2,'source'=>ErpnetProduto::getItens3()));
		echo CHtml::activeTextField($model,"[$index]id_produto",array('class'=>'input-xlarge'));
		echo "<script>jQuery(function($) {"."jQuery('#{$id}').autocomplete($options);"."});</script>";
	}
		/*
		$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
			'model' => $model,
			'attribute' => "[$index]id_produto",
			'source'=>ErpnetProduto::getItens3(),
			// additional javascript options for the autocomplete plugin
			'options'=>array(
					'minLength'=>'2',
			),
			'htmlOptions'=>array(
					'class'=>'input-xlarge',
			),
		));*/
	else 
		echo CHtml::activeDropDownList($model,"[$index]id_produto",ErpnetProduto::getItens(),array('class'=>'input-xlarge','empty'=>'--Selecione--'));
	//*/
	
	?>
	<?php //echo CHtml::error($model,"[$index]id_produto"); ?>
</td>
	
<td>
	<?php echo CHtml::activeTextField($model,"[$index]quantidade",array('class'=>'input-small')); ?>
	<?php //echo CHtml::error($model,"[$index]quantidade"); ?>
</td>
<td>
	<?php echo CHtml:: activeTextField($model,"[$index]valor",array('class'=>'input-small')); 
	/*
	$this->widget('CMaskedTextField', array(
			'model' => $model,
			'attribute' => "[$index]valor",
			'mask' => '?9.999,99',
			'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
			'htmlOptions' => array(
				//'size' => 6,
				'class'=>'input-small',
			),
	));*/
	?>
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