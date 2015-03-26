<?php
/* @var $this ErpnetOrdemController */
/* @var $model ErpnetOrdem */
/* @var $modelOrdemItem ErpnetOrdemItem */
/* @var $form CActiveForm */
/* @var $tabular array() XTabularInput */
?>
	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'referencia',array('class'=>'span3')); ?>	
		<?php echo $form->labelEx($model,'data_termino',array('class'=>'span2')); ?>	
	</div>
	<div class="controls-row">
		<?php echo $form->TextField($model,'referencia',array('class'=>'span3')); ?>
		<?php 
			$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => $model,
				'attribute' => 'data_termino',
				//'value' => $model->data_termino,
				'language'=>'pt',
				// additional javascript options for the date picker plugin
				'options' => array (
						'showAnim' => 'fold',
						'showButtonPanel' => false,
						'autoSize' => true,
				),
				'htmlOptions'=>array(
						'class'=>'span2',
						'value'=>Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(CTimestamp, Yii::app()->locale->dateFormat),'medium',null),
				),
			) );
		?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'referencia',array('class'=>'span3')); ?>
		<?php echo $form->error($model,'data_termino',array('class'=>'span2')); ?>
	</div>

	<div class="controls-row">
		
		<?php echo $form->labelEx($model,'id_wbs',array('class'=>'span3')); ?>
		<?php echo $form->labelEx($model,'id_wbs_destino',array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">	
		<?php echo $form->DropDownList($model,'id_wbs',ErpnetWbs::getItens(true,'estoque'),array('class'=>'span3')); ?>
		<?php //echo $form->DropDownList($model,'id_wbs_destino',ErpnetWbs::getItens(true,'valores'),array('class'=>'span3')); 
			$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
				'model' => $model,
				'attribute' => "id_wbs_destino",
				//'name'=>"[$index]id_wbs",
				'source'=>ErpnetWbs::getItens2(true,'valores'),//array('ac1','ac2','ac3'),
				// additional javascript options for the autocomplete plugin
				'options'=>array(
						'minLength'=>'2',
				),
				'htmlOptions'=>array(
						//'style'=>'height:20px;',
						'class'=>'input-large',
				),
			));
		?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'id_wbs',array('class'=>'span3')); ?>
		<?php echo $form->error($model,'id_wbs_destino',array('class'=>'span3')); ?>
	</div>
	<?php echo $form->hiddenField($model,'tipo',array('value'=>'consumo')) ?>
	
	<?php $this->widget('ext.widgets.tabularinput.XTabularInput',$tabular); ?>