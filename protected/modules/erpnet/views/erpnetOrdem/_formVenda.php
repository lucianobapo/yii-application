<?php
/* @var $this ErpnetOrdemController */
/* @var $model ErpnetOrdem */
/* @var $modelOrdemItem ErpnetOrdemItem */
/* @var $form CActiveForm */
/* @var $tabular array() XTabularInput 
 * 
 *  FIXME:  verificar busca de produto em itens adicionais
 * */

?>		
	<div class="controls-row">
		<?php echo $form->labelEx($model,'id_cliente',array('class'=>'span5','id'=>'novo')); ?>	
		<?php echo $form->checkBox($model,'status_fechado' , array() ); ?>
		<?php echo $form->labelEx($model,'status_fechado', array('class'=>'span2','align'=>'center')); ?>	
	</div>

	<div class="controls-row">
	
		<?php 
	if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->search_cliente_venda){
		
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->cadastra_cliente_venda) {
			$response=',response: function(event, ui) { if (ui.content.length === 0) {'.
				'$("#novo").html("'.$model->getAttributeLabel('id_cliente');
			if ($model->isAttributeRequired('id_cliente')) $response=$response.str_replace('"', '', CHtml::$afterRequiredLabel);
			$response=$response.'");'.
				'$("#labelEndereco").empty();'.
				'$("#fieldEndereco").empty();'.
        		'$("#novo").prepend("Novo ");'.
        		'$("#labelEndereco").prepend(\''.CHtml::activeLabelEX(ErpnetCliente::model(),'endereco',array('class'=>'span5')).'\');'.
        		'$("#fieldEndereco").prepend(\''.CHtml::activeTextField(ErpnetCliente::model(),"endereco",array('class'=>'span5')).'\');'.
        	'} else { '.
        		'$("#novo").html("'.$model->getAttributeLabel('id_cliente');
			if ($model->isAttributeRequired('id_cliente')) $response=$response.str_replace('"', '', CHtml::$afterRequiredLabel);
			$response=$response.'");'.
        		'$("#labelEndereco").empty();'.
        		'$("#fieldEndereco").empty(); } }';
		} else $response='';
		
		echo CHtml::activeTextField($model,"id_cliente",array('class'=>'span5'));
		
		$attribute="id_cliente";
		$htmlOptions=array();
		CHtml::resolveNameID($model, $attribute, $htmlOptions);
		echo "<script type='text/javascript'>jQuery(function($) {"."jQuery('#{$htmlOptions['id']}').autocomplete({'minLength':2,source:".CJavaScript::encode(ErpnetCliente::getItens3(true,'tipo_cliente')).$response."});"."});</script>";
		/*$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
			'model' => $model,
			'attribute' => "id_cliente",
			'source'=>ErpnetCliente::getItens3(true,'tipo_cliente'),
			// additional javascript options for the autocomplete plugin
			'options'=>array(
					'minLength'=>'2',
			),
			'htmlOptions'=>array(
					'class'=>'span5',
			),
		));*/
	} else 
		echo $form->DropDownList($model,'id_cliente',ErpnetCliente::getItens(true,'tipo_cliente'),array('class'=>'span5','empty'=>'--Selecione--')); ?>	
	</div>
	<div class="controls-row" id='labelEndereco'>
	</div>
	<div class="controls-row" id='fieldEndereco'>
	</div>
	<div class="controls-row">
		<?php if ( (!$model->isNewRecord)&&(($endereco=ErpnetCliente::model()->findByPk(ErpnetCliente::getIdSearch($model->id_cliente))->endereco)!='') ) echo utf8_encode(CHtml::label('<b> &nbsp;&nbsp;&nbsp; Endere�o: '.$endereco.'</b>', $for,array('class'=>'span2') )); ?>
	</div>
	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'referencia',array('class'=>'span4')); ?>		
		<?php if (!$model->isNewRecord) echo CHtml::label(utf8_encode('<b> &nbsp;&nbsp;&nbsp; Valor Total da Ordem: '.Yii::app()->numberFormatter->formatCurrency($model->valor,'R$').'</b>'), false,array('class'=>'span3') ); ?>
	</div>

	<div class="controls-row">
		<?php echo $form->TextField($model,'referencia',array('class'=>'span4')); ?>
		
	</div>
	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'obs',array('class'=>'span4')); ?>	
	</div>
	<div class="controls-row">
		<?php echo $form->TextField($model,'obs',array('class'=>'span4')); ?>
		
	</div>
	
	<div class="controls-row">
		<?php echo $form->labelEx($model,'data_termino',array('class'=>'span2')); ?>
		<?php echo $form->labelEx($model,'id_wbs',array('class'=>'span3')); ?>
		<?php echo $form->labelEx($model,'pagamento',array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">	
		<?php 
			$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
				'model' => $model,
				'attribute' => 'data_termino',
				//'value' => $model->data_termino,
				'language'=>'pt',
				// additional javascript options for the date picker plugin
				'options' => array (
						'showAnim' => 'fold',
						'showButtonPanel' => true,
						'autoSize' => true,
				),
				'htmlOptions'=>array(
						'class'=>'span2',
						//'value'=>Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(CTimestamp, Yii::app()->locale->dateFormat),'medium',null),
				),
			) );
		?>
		<?php echo $form->DropDownList($model,'id_wbs',ErpnetWbs::getItens(true,'estoque'),array('class'=>'span3')); ?>
		<?php echo $form->DropDownList($model,'pagamento',Yii::app()->params['pagamento'],array('class'=>'span3')); ?>
	</div>
	<div class="controls-row">
		<div class="spam2">
			<?php echo $form->labelEx($model,'desconto',array('class'=>'')); ?>
			<?php echo $form->TextField($model,'desconto',array('class'=>'span2')); ?>
			<?php //echo $form->error($model,'pagamento',array('class'=>'span3')); ?>
		</div>

	</div>
	<?php echo $form->hiddenField($model,'tipo',array('value'=>'venda')) ?>
	
	<?php $this->widget('ext.widgets.tabularinput.XTabularInput',$tabular); ?>