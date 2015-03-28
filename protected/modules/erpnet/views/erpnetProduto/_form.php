<?php
/* @var $this ErpnetProdutoController */
/* @var $model ErpnetProduto */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'erpnet-produto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo utf8_encode(Yii::t('app', 'appFormLabel1', array(), 'i18n')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-block-delivery">
		<div class="form-inline-delivery col-sm-3">
			<?php echo $form->labelEx($model,'cod_barra', array('class'=>'')); ?>
			<?php echo $form->textField($model,'cod_barra',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		</div>
		<div class="form-inline-delivery col-sm-3">
			<?php echo $form->labelEx($model,'cod_fiscal', array('class'=>'')); ?>
			<?php echo $form->textField($model,'cod_fiscal',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		</div>
		<div class="form-inline-delivery col-sm-4">
			<?php echo $form->labelEx($model,'descricao', array('class'=>'')); ?>
			<?php
			//echo $form->textField($model,'descricao',array('size'=>60,'maxlength'=>255));
			$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
				'model' => $model,
				'attribute' => "descricao",
				'source'=>$itens_descricao,
				// additional javascript options for the autocomplete plugin
				'options'=>array(
					'minLength'=>'2',
				),
				'htmlOptions'=>array(
					'class'=>'form-control',
				),
			));
			?>
		</div>
	</div>

	<div class="form-block-delivery">

		<div class="form-inline-delivery col-md-2">
			<?php echo $form->labelEx($model,'valor', array('class'=>'')); ?>
			<?php echo $form->textField($model,'valor',array('class'=>'form-control')); ?>
		</div>
		<div class="form-inline-delivery col-md-2">
			<?php echo $form->labelEx($model,'valor_venda', array('class'=>'')); ?>
			<?php echo $form->textField($model,'valor_venda',array('class'=>'form-control')); ?>
		</div>
		<div class="form-inline-delivery col-md-2">
			<?php echo $form->labelEx($model,'valor_promocao', array('class'=>'')); ?>
			<?php echo $form->textField($model,'valor_promocao',array('class'=>'form-control')); ?>
		</div>
		<div class="form-inline-delivery col-md-2">
			<?php echo $form->labelEx($model,'moeda', array('class'=>'')); ?>
			<?php echo $form->DropDownList($model,'moeda',Yii::app()->params['moedas'],array('class'=>'form-control')); ?>
		</div>
		<div class="form-inline-delivery col-md-2">
			<?php echo $form->labelEx($model,'estoque_minimo', array('class'=>'')); ?>
			<?php echo $form->textField($model,'estoque_minimo',array('class'=>'form-control')); ?>
		</div>
	</div>

	<div class="form-block-delivery">
		<div class="form-inline-delivery ">
			<?php echo $form->labelEx($model,'fabricante', array('class'=>'')); ?>
			<?php echo $form->textField($model,'fabricante',array('class'=>'','size'=>60,'maxlength'=>255)); ?>
		</div>
		<div class="form-inline-delivery ">
			<?php echo $form->labelEx($model,'uom', array('class'=>'')); ?>
			<?php echo $form->DropDownList($model,'uom',Yii::app()->params['unidades'],array('class'=>'')); ?>
		</div>
		<div class="form-inline-delivery ">
			<?php echo $form->labelEx($model,'obs', array('class'=>'')); ?>
			<?php echo $form->textField($model,'obs',array('class'=>'')); ?>
		</div>
	</div>
	<div class="form-block-delivery">
		<div class="">
			<?php echo $form->labelEx($model,'categoria', array('class'=>'')); ?>
			<?php echo $form->textField($model,'categoria',array('class'=>'','size'=>60,'maxlength'=>255)); ?>
		</div>
	</div>

    <div class="form-block-delivery">
        <div class="">
            <?php echo $form->checkBox($model,'destaque' , array()); ?>
            <?php echo $form->labelEx($model,'destaque', array('class'=>'')); ?>
        </div>
        <div class="">
            <?php echo $form->checkBox($model,'promocao' , array()); ?>
            <?php echo $form->labelEx($model,'promocao', array('class'=>'')); ?>
        </div>
    </div>



	<div class="form-block-delivery">
		<?php echo $form->labelEx($model,'erpnetGrupoProdutos'); ?>
		<?php echo $form->dropDownList($model, 'erpnetGrupoProdutos', CHtml::listData(ErpnetGrupoProduto::model()->findAll('empresa=:empresa', array(':empresa'=>Yii::app()->user->empresa)), 'id', 'nome'), array('multiple'=>'multiple', 'size'=>4)); ?>
		<?php echo $form->error($model,'erpnetGrupoProdutos'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? utf8_encode(Yii::t('app', 'formCreate', array(), 'i18n')) : utf8_encode(Yii::t('app', 'formSave', array(), 'i18n'))); ?>
		<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->