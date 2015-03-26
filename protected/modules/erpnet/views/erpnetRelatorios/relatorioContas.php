<?php
/* @var $this ErpnetRelatoriosController */
?>

<h3><?php //var_dump($debug);
		echo utf8_encode(Yii::t('erpnetUi', 'viewRelatorioContasTitle', array(), 'i18n')); //var_dump($mostra); ?></h3>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'relatorios-form',
	'enableClientValidation'=>true,
	//'clientOptions'=>array(
	//	'validateOnSubmit'=>true,
	//),
)); ?>

	<div class="controls-row">
		<?php echo $form->labelEx($model,'tanque', array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'produto', array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'data_inicial', array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'data_final', array('class'=>'span2')); ?>		
	</div>
	
	<div class="controls-row">
		<?php echo $form->dropDownList($model,'tanque',ErpnetWbs::getItens(true,'estoque') , array('empty' => utf8_encode(Yii::t('erpnetUi', 'viewRelatoriosGeralTanque', array(), 'i18n')),'class'=>'span2')); ?>
		<?php echo $form->dropDownList($model,'produto',ErpnetProduto::getItens(true,'estoque') , array('empty' => utf8_encode(Yii::t('erpnetUi', 'viewRelatoriosGeralTanque', array(), 'i18n')),'class'=>'span2')); ?>
		<?php //echo $form->textField($model,'data_inicial', array('class'=>'span2','value'=>$inicial)); 
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
						'value'=>$inicial
				),
			) );
		?>
		<?php //echo $form->textField($model,'data_final', array('class'=>'span2','value'=>$final)); 
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
						'value'=>$final
				),
			) );
		?>	
		<?php echo CHtml::submitButton(utf8_encode(Yii::t('erpnetUi', 'viewRelatorioEnviar', array(), 'i18n')), array('class'=>'span2')); ?>	
	</div>

	<div class="row">
		<?php //echo $form->error($model,'tanque', array('class'=>'span2')); ?>
		<?php //echo $form->error($model,'produto', array('class'=>'span2')); ?>
		<?php //echo $form->error($model,'data_inicial', array('class'=>'span2')); ?>
		<?php //echo $form->error($model,'data_final', array('class'=>'span2')); ?>
	</div>

	<div class="row buttons">
		
	</div>

<?php $this->endWidget(); ?>
</div>

  

    <?php
    $this->widget('zii.widgets.jui.CJuiTabs', array(
		'tabs'=>array(
			
			'Contas A Receber'=>$this->renderPartial('_conta', array(
				//'model' => $model,
				'gridDataProvider' => $modelFatura,
				'itens' => $itens,
				'saldo' => $saldoFatura,
			),true),
			'Conta Estoque'=>$this->renderPartial('_conta', array(
				//'model' => $model,
				'gridDataProvider' => $gridDataProvider,
				'itens' => $itens,
				'saldo' => $saldo,
			),true),
			'Contas A Pagar'=>$this->renderPartial('_conta', array(
				//'model' => $model,
				'gridDataProvider' => $modelPagar,
				'itens' => $itens,
				'saldo' => $saldoPagar,
			),true),
		),
		// additional javascript options for the tabs plugin
		'options'=>array(
			'collapsible'=>true,
		),
	));
	?>
  