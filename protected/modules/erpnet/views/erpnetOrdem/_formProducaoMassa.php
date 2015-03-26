<?php
/* @var $this ErpnetOrdemController */
/* @var $model ErpnetOrdem */
/* @var $modelOrdemItem ErpnetOrdemItem */
/* @var $form CActiveForm */
/* @var $tabular array() XTabularInput */
?>

	<div class="controls-row">
		<?php echo $form->labelEx($model,'id_produto',array('class'=>'span3')); ?>	
		<?php echo $form->labelEx($model,'turno',array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'id_wbs',array('class'=>'span3')); ?>
				
	</div>

	<div class="controls-row">
		<?php echo $form->DropDownList($model,'id_produto',ErpnetProduto::getItens(),array('class'=>'span3')); ?>
		<?php echo $form->DropDownList($model,'turno',array('manha'=>utf8_encode('Manhã'), 'tarde'=>'Tarde'),array('class'=>'span2')); ?>
		
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
			'model' => $model,
			'attribute' => "id_wbs",
			'source'=>ErpnetWbs::getItens2(true,'producao'),//array('ac1','ac2','ac3'),
			// additional javascript options for the autocomplete plugin
			'options'=>array(
					'minLength'=>'2',
			),
			'htmlOptions'=>array(
					'class'=>'span3',
			),
		));
	?>	
		
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'id_produto',array('class'=>'span3')); ?>
		<?php echo $form->error($model,"turno",array('class'=>'span2')); ?>
		<?php echo $form->error($model,"id_wbs",array('class'=>'span3')); ?>
		
	</div>
	
	<?php $this->widget('ext.widgets.tabularinput.XTabularInput',$tabular); ?>