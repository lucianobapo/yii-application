<?php
/* @var $this ErpnetFaturaController */
/* @var $model ErpnetFatura */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'erpnet-fatura-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="controls-row">
		<?php echo $form->labelEx($model,'data_movimento',array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'id_produto',array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'id_wbs',array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">	
		<?php 
			$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => $model,
				'attribute' => 'data_movimento',
				'value' => $model->data_movimento,
				'language'=>'pt',//Yii::app()->getLanguage(),
				// additional javascript options for the date picker plugin
				'options' => array (
						'showAnim' => 'fold',
						'showButtonPanel' => false,
						'autoSize' => true,
						//'width'=>400,
						//'height'=>250,
						//'dateFormat' => Yii::app()->locale->dateFormat,
						//'defaultDate' => today(),
				),
				'htmlOptions'=>array(
						//'style' => 'font-size:10px;',
						'class'=>'span2',
						//'value'=>CTimestamp::formatDate(Yii::app()->locale->dateFormat),
						'value'=>Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(CTimestamp, Yii::app()->locale->dateFormat),'medium',null),
						//'value'=>Yii::app()->locale->dateFormat,
				),
			) );
		?>
		<?php echo $form->DropDownList($model,'id_produto',ErpnetProduto::getItens(),array('class'=>'span2')); ?>
		<?php echo $form->DropDownList($model,'id_wbs',ErpnetWbs::getItens(true,'producao'),array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'data_movimento',array('class'=>'span2')); ?>
		<?php echo $form->error($model,'id_produto',array('class'=>'span2')); ?>
		<?php echo $form->error($model,'id_wbs',array('class'=>'span3')); ?>
	</div>
	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'moeda',array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'quantidade',array('class'=>'span2')); ?>	
		<?php echo $form->labelEx($model,'valor',array('class'=>'span2')); ?>		
	</div>

	<div class="controls-row">
		<?php echo $form->DropDownList($model,'moeda',Yii::app()->params['moedas'],array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'quantidade',array('class'=>'span2')); ?>	
		<?php echo $form->textField($model,'valor',array('class'=>'span2')); ?>	
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'moeda',array('class'=>'span2')); ?>
		<?php echo $form->error($model,'quantidade',array('class'=>'span2')); ?>
		<?php echo $form->error($model,'valor',array('class'=>'span2')); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? utf8_encode(Yii::t('app', 'formCreate', array(), 'i18n')) : utf8_encode(Yii::t('app', 'formSave', array(), 'i18n'))); ?>
		<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
		<?php echo $form->hiddenField($model,'usuario',array('value'=>Yii::app()->user->name)) ?>
		<?php echo $form->hiddenField($model,'turno',array('value'=>'manha')) ?>
		<?php echo $form->hiddenField($model,'tipo',array('value'=>'saida')) ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->