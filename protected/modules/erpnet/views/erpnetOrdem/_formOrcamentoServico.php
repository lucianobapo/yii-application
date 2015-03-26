<?php
/* @var $this ErpnetOrdemController */
/* @var $model ErpnetOrdem */
/* @var $modelOrdemItem ErpnetOrdemItem */
/* @var $form CActiveForm */
/* @var $tabular array() XTabularInput */
?>

	<div class="controls-row">
		<?php echo $form->labelEx($model,'id_cliente',array('class'=>'span5')); ?>
		<?php echo $form->checkBox($model,'status_fechado' , array() ); ?>
		<?php echo $form->labelEx($model,'status_fechado', array('class'=>'span2','align'=>'center')); ?>		
	</div>

	<div class="controls-row">
		<?php echo $form->DropDownList($model,'id_cliente',ErpnetCliente::getItens(true,'tipo_cliente'),array('class'=>'span5','empty'=>'--Selecione--')); ?>	
	</div>
	<div class="controls-row">
		<?php //echo $form->error($model,'id_cliente',array('class'=>'span5')); ?>
		<?php //echo $form->error($model,'status_fechado', array('class'=>'span3')); ?>
	</div>
	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'referencia',array('class'=>'span4')); ?>	
		<?php if (!$model->isNewRecord) echo CHtml::label(utf8_encode('<b> &nbsp;&nbsp;&nbsp; Valor Total da Ordem: '.Yii::app()->numberFormatter->formatCurrency($model->valor,'R$').'</b>'), false,array('class'=>'span3') ); ?>	
	</div>

	<div class="controls-row">
		<?php echo $form->TextField($model,'referencia',array('class'=>'span4')); ?>
	</div>
	<div class="controls-row">
		<?php //echo $form->error($model,'referencia',array('class'=>'span5')); ?>
	</div>

	<div class="controls-row">
		<?php echo $form->labelEx($model,'data_termino',array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'id_wbs',array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">	
		<?php 
			$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => $model,
				'attribute' => 'data_termino',
				'value' => $model->data_termino,
				'language'=>'pt',
				// additional javascript options for the date picker plugin
				'options' => array (
						'showAnim' => 'fold',
						'showButtonPanel' => false,
						'autoSize' => true,
				),
				'htmlOptions'=>array(
						'class'=>'span2',
						//'value'=>'',//Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(CTimestamp, Yii::app()->locale->dateFormat),'medium',null),
				),
			) );
		?>
		<?php echo $form->DropDownList($model,'id_wbs',ErpnetWbs::getItens(true,'estoque'),array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php //echo $form->error($model,'data_termino',array('class'=>'span2')); ?>
		<?php //echo $form->error($model,'id_wbs',array('class'=>'span3')); ?>
	</div>
	<?php echo $form->hiddenField($model,'tipo',array('value'=>'orcamentoServico')) ?>
	
	<?php $this->widget('ext.widgets.tabularinput.XTabularInput',$tabular); ?>