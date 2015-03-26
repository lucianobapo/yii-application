<?php
/* @var $this ErpnetConfigController */
/* @var $model ErpnetConfig */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'erpnet-config-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php if(Yii::app()->user->hasFlash('config')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('config'); ?>
</div>
<?php endif; ?>

	<p class="note"><?php //echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'mostra_lang' , array()); ?>
		<?php echo $form->labelEx($model,'mostra_lang', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'mostra_lang', array('class'=>'span3')); ?>
	</div>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'mostra_vendas' , array()); ?>
		<?php echo $form->labelEx($model,'mostra_vendas', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'mostra_vendas', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->checkBox($model,'mostra_compras' , array()); ?>
		<?php echo $form->labelEx($model,'mostra_compras', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'mostra_compras', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->checkBox($model,'mostra_servico' , array()); ?>
		<?php echo $form->labelEx($model,'mostra_servico', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'mostra_servico', array('class'=>'span3')); ?>
	</div>
	
	<p></p>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'movimenta_estoque' , array()); ?>
		<?php echo $form->labelEx($model,'movimenta_estoque', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'movimenta_estoque', array('class'=>'span3')); ?>
	</div>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'movimenta_conta_receber' , array()); ?>
		<?php echo $form->labelEx($model,'movimenta_conta_receber', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'movimenta_conta_receber', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->checkBox($model,'movimenta_conta_pagar' , array()); ?>
		<?php echo $form->labelEx($model,'movimenta_conta_pagar', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'movimenta_conta_pagar', array('class'=>'span3')); ?>
	</div>
	
	<p></p>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'ordem_venda_fechada' , array()); ?>
		<?php echo $form->labelEx($model,'ordem_venda_fechada', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'ordem_venda_fechada', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->checkBox($model,'ordem_compra_fechada' , array()); ?>
		<?php echo $form->labelEx($model,'ordem_compra_fechada', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'ordem_compra_fechada', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->checkBox($model,'ordem_servico_fechada' , array()); ?>
		<?php echo $form->labelEx($model,'ordem_servico_fechada', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'ordem_servico_fechada', array('class'=>'span3')); ?>
	</div>
	
	<p></p>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'search_produto_venda' , array()); ?>
		<?php echo $form->labelEx($model,'search_produto_venda', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'search_produto_venda', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->checkBox($model,'search_cliente_venda' , array()); ?>
		<?php echo $form->labelEx($model,'search_cliente_venda', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'search_cliente_venda', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->checkBox($model,'cadastra_cliente_venda' , array()); ?>
		<?php echo $form->labelEx($model,'cadastra_cliente_venda', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'cadastra_cliente_venda', array('class'=>'span3')); ?>
	</div>
	
	<p></p>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'required_cliente_cnpj' , array()); ?>
		<?php echo $form->labelEx($model,'required_cliente_cnpj', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'required_cliente_cnpj', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->checkBox($model,'required_produto_codfiscal' , array()); ?>
		<?php echo $form->labelEx($model,'required_produto_codfiscal', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'required_produto_codfiscal', array('class'=>'span3')); ?>
	</div>
	
	<p></p>
	
	<div class="controls-row">
		<?php echo $form->checkBox($model,'outras_moedas' , array()); ?>
		<?php echo $form->labelEx($model,'outras_moedas', array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<?php echo $form->error($model,'outras_moedas', array('class'=>'span3')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? utf8_encode(Yii::t('app', 'formCreate', array(), 'i18n')) : utf8_encode(Yii::t('app', 'formSave', array(), 'i18n'))); ?>
<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->