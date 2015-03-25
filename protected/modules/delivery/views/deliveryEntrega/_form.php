<?php
/* @var $this DeliveryEntregaController */
/* @var $model DeliveryEntrega */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'delivery-entrega-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'confirma'=>Helpers::t('appUi','Este pedido ainda não foi enviado!',array(),'i18n',null,false),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row buttons">
		<a href="<?php echo $this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/cancel', array("id"=>$id) ); ?>"
		   class="btn btn-small btn-danger" click-once="<?php echo Helpers::t('app', 'Carregando...'); ?>"><?php echo Helpers::t('appUi', 'Cancelar Pedido'); ?></a>
		<a href="<?php echo $this->createUrl ( '/' . Helpers::getModuleName() . '/deliveryPedido/update', array("id"=>$id) ); ?>"
		   class="btn btn-small btn-warning" click-once="<?php echo Helpers::t('app', 'Carregando...'); ?>"><?php echo Helpers::t('appUi', 'Revisar Pedido'); ?></a>
		<?php echo CHtml::submitButton(Helpers::t('appUi', 'Confirmar Entrega'),array('class'=>'btn btn-large btn-success','click-once'=>Helpers::t('app', 'Carregando...'))); ?>
		<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
		<?php echo $form->hiddenField($model,'usuario',array('value'=>Yii::app()->user->social_identifier)) ?>
		<?php echo $form->hiddenField($model,'id_ordem',array('value'=>$id)) ?>
		<?php echo $form->hiddenField($model,'cep',array('value'=>$parceiro->cep)) ?>
		<?php echo $form->hiddenField($model,'endereco',array('value'=>$parceiro->endereco,'class'=>'changeOnReady')) ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->