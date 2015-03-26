<?php
/* @var $this ErpnetComprasController */
/* @var $model ErpnetCompras */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'erpnet-compras-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="controls-row">	
		<?php echo $form->labelEx($model,'num_ordem',array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'data_emissao',array('class'=>'span2')); ?>
	</div>	
	<div class="controls-row">	
		<?php echo $form->textField($model,'num_ordem',array('class'=>'span2','size'=>60,'maxlength'=>255)); ?>		
		<?php 
			$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => $model,

				'attribute' => 'data_emissao',
				'value' => $model->data_emissao,
				'language'=>'pt',
				// additional javascript options for the date picker plugin
				'options' => array (
						'showAnim' => 'fold',
						//'showButtonPanel' => true,
						//'autoSize' => true,
				),
				'htmlOptions'=>array(
						'value'=>Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(CTimestamp, Yii::app()->locale->dateFormat),'medium',null),
						'class'=>'span2',
						//'style'=>'height:20px;'
				),
			) )
		?>
		<?php //echo $form->textField($model,'data_emissao'); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'num_ordem',array('class'=>'span2')); ?>
		<?php echo $form->error($model,'data_emissao',array('class'=>'span2')); ?>
	</div>
	
	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'moeda',array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'conversao_brl',array('class'=>'span2')); ?>   
	</div>
	<div class="controls-row">
		<?php echo $form->textField($model,'moeda',array('class'=>'span2','value' =>'BRL','size'=>3,'maxlength'=>3)); ?>		
		<?php echo $form->textField($model,'conversao_brl',array('class'=>'span2','value' =>'1.00')); ?>		
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'moeda',array('class'=>'span2')); ?>
		<?php echo $form->error($model,'conversao_brl',array('class'=>'span2')); ?>
	</div>

	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'incoterm',array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'incoterm_local',array('class'=>'span2')); ?>    
	</div>
	<div class="controls-row">				
		<?php echo $form->textField($model,'incoterm',array('class'=>'span2','size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->textField($model,'incoterm_local',array('class'=>'span2','size'=>60,'maxlength'=>255)); ?>
	</div>	
	<div class="controls-row">		
		<?php echo $form->error($model,'incoterm',array('class'=>'span2')); ?>
		<?php echo $form->error($model,'incoterm_local',array('class'=>'span2')); ?>		
	</div>

	<div class="controls-row">
		<?php echo $form->labelEx($model,'texto',array('class'=>'span4')); ?>
	</div>
	<div class="controls-row">	
		<?php echo $form->textArea($model,'texto',array('class'=>'span4','rows'=>4, 'cols'=>50)); ?>
	</div>
	<div class="controls-row">	
		<?php echo $form->error($model,'texto',array('class'=>'span4')); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? utf8_encode(Yii::t('app', 'formCreate', array(), 'i18n')) : utf8_encode(Yii::t('app', 'formSave', array(), 'i18n'))); ?>
<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->