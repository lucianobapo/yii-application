<?php
/* @var $this ErpnetRelatoriosController */
?>

<h3><?php echo utf8_encode(Yii::t('erpnetUi', 'viewRelatorioTitle', array(), 'i18n')); //var_dump($mostra); ?></h3>



<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'relatorios-form2',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	
	<?php echo $form->errorSummary($model); ?>
	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'tanque', array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'produto', array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'data_inicial', array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'data_final', array('class'=>'span2')); ?>		
	</div>
	
	<div class="controls-row">
		<?php echo $form->dropDownList($model,'tanque',ErpnetWbs::getItens(true,'estoque') , array('empty' => utf8_encode(Yii::t('erpnetUi', 'viewRelatoriosGeralTanque', array(), 'i18n')),'class'=>'span2')); ?>
		<?php echo $form->dropDownList($model,'produto',ErpnetProduto::getItens(true,'estoque') , array('class'=>'span2')); ?>
		<?php //echo $form->textField($model,'data_inicial', array('value'=>'01/'.date('m/Y'),'class'=>'span2'));
			//*
			if ($model->data_inicial=='') $value='01/'.date('m/Y');
			else $value=$model->data_inicial;
			$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => $model,
				'attribute' => 'data_inicial',
				'language'=>'pt',
				// additional javascript options for the date picker plugin
				'options' => array (
						'showAnim' => 'fold',
						'showButtonPanel' => false,
						'autoSize' => true,
				),
				'htmlOptions'=>array(
						'class'=>'span2',
						'value'=>$value
				),
			) ); //*/?>
		<?php //echo $form->textField($model,'data_final', array('value'=>'15/'.date('m/Y'),'class'=>'span2'));
			//*
			if ($model->data_final=='') $value='15/'.date('m/Y');
			else $value=$model->data_final;
			$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => $model,
				'attribute' => 'data_final',
				'language'=>'pt',
				// additional javascript options for the date picker plugin
				'options' => array (
						'showAnim' => 'fold',
						'showButtonPanel' => false,
						'autoSize' => true,
				),
				'htmlOptions'=>array(
						'class'=>'span2',
						'value'=>$value
				),
			) ); //*/?>	
		<?php echo CHtml::submitButton(utf8_encode(Yii::t('erpnetUi', 'viewRelatorioEnviar', array(), 'i18n')), array('class'=>'span2')); ?>	
	</div>

	<div class="controls-row">
		<?php echo $form->error($model,'tanque', array('class'=>'span2')); ?>
		<?php echo $form->error($model,'produto', array('class'=>'span2')); ?>
		<?php echo $form->error($model,'data_inicial', array('class'=>'span2')); ?>
		<?php echo $form->error($model,'data_final', array('class'=>'span2')); ?>
	</div>
	
	<div class="controls-row">
		<?php //echo $form->labelEx($model,'detalhe_dia', array('class'=>'span2')); ?>
		<?php //echo $form->labelEx($model,'data_inicial', array('class'=>'span2')); ?>
		<?php //echo $form->labelEx($model,'data_final', array('class'=>'span2')); ?>		
	</div>
	<div class="controls-row">
		<?php echo $form->checkBox($model,'detalhe_dia' , array('class'=>'span1')); ?>
		<?php echo $form->labelEx($model,'detalhe_dia', array('class'=>'span2')); ?>
		
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'detalhe_dia', array('class'=>'span3')); ?>
		<?php //echo $form->error($model,'detalhe_produtor', array('class'=>'span3')); ?>
		<?php //echo $form->error($model,'data_final', array('class'=>'span2')); ?>
	</div>
	
	<div class="controls-row">
		
		<?php echo $form->checkBox($model,'detalhe_produtor' , array('class'=>'span1')); ?>
		<?php echo $form->labelEx($model,'detalhe_produtor', array('class'=>'span2')); ?>
		
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'detalhe_produtor', array('class'=>'span3')); ?>
		<?php //echo $form->error($model,'data_final', array('class'=>'span2')); ?>
	</div>
	
	<div class="controls-row">
		
		<?php echo $form->checkBox($model,'exportar_excel' , array('class'=>'span1')); ?>
		<?php echo $form->labelEx($model,'exportar_excel', array('class'=>'span2')); ?>
		
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'exportar_excel', array('class'=>'span3')); ?>
		<?php //echo $form->error($model,'data_final', array('class'=>'span2')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<?php $this->renderPartial('_tabela', array('itens'=>$itens,'gridDataProvider'=>$gridDataProvider,'obs' => $obs,)); ?>
