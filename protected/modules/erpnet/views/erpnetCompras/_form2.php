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

		
		<?php 
		$persons=array();
		$criteria = new CDbCriteria ();
		if (! Yii::app ()->user->checkAccess ( 'admin' ))
			$criteria->compare ( 'empresa', Yii::app ()->user->empresa );
		$trips = $model->findAll($criteria);
		foreach($trips as $t) array_push($persons, $model->findbyPk($t->id));
		//*
		$this->widget('ext.widgets.tabularinput.XTabularInput',array(
				'models'=>$persons,
				'containerTagName'=>'table',
				'headerTagName'=>'thead',
				'header'=>'<tr><td>'.
					CHtml::activeLabelEX(User::model(),'num_ordem',array()).'</td><td>'.
					CHtml::activeLabelEX(User::model(),'data_emissao',array()).'</td><td>'.
					CHtml::activeLabelEX(User::model(),'moeda',array()).'</td><td>'.
					CHtml::activeLabelEX(User::model(),'conversao_brl',array()).'</td><td>'.
					CHtml::activeLabelEX(User::model(),'incoterm',array()).'</td><td>'.
					CHtml::activeLabelEX(User::model(),'incoterm_local',array()).'</td>'.
					'</tr>',
				'inputContainerTagName'=>'tbody',
				'inputTagName'=>'tr',
				'inputView'=>'extensions/_tabularInputAsTable',
				'inputUrl'=>$this->createUrl('addTabularInputsAsTable'),
				'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
				'addLabel'=>Yii::t('ui','Add new row'),
				'addHtmlOptions'=>array('class'=>'blue pill full-width'),
				'removeTemplate'=>'<td>{link}</td>',
				'removeLabel'=>Yii::t('ui','Delete'),
				'removeHtmlOptions'=>array('class'=>'red pill'),
		));
		//*/
		
		/*
			
			$this->widget('ext.widgets.tabularinput.XTabularInput',array(
 					'models'=>$persons,
 					'containerTagName'=>'table',
 					'headerTagName'=>'thead',
					'headerCssClass'=>'controls-row',
					'header'=>''.
					CHtml::activeLabelEX(User::model(),'num_ordem',array('class'=>'span2')).''.
					CHtml::activeLabelEX(User::model(),'data_emissao',array('class'=>'span2')).''.
					CHtml::activeLabelEX(User::model(),'moeda',array('class'=>'span1')).''.
					CHtml::activeLabelEX(User::model(),'conversao_brl',array('class'=>'span2')).''.
					CHtml::activeLabelEX(User::model(),'incoterm',array('class'=>'span1')).''.
					CHtml::activeLabelEX(User::model(),'incoterm_local',array('class'=>'span2')).''.
					'',
			
					
 					'inputContainerTagName'=>'tbody',
 					'inputTagName'=>'tr',
					'inputContainerCssClass'=>'',
					'containerCssClass'=>'',
					'inputCssClass'=>'controls-row',
					'indexCssClass'=>'',
 					'inputView'=>'extensions/_tabularInputAsTable',
 					'inputUrl'=>$this->createUrl('/request/addTabularInputsAsTable'),
					//'containerHtmlOptions'=>array('class'=>'controls-row'),
					//'inputContainerHtmlOptions'=>'',	
									
 					//'addTemplate'=>'{link}',
					'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
 					'addLabel'=>Yii::t('ui','Add new row'),
 					'addHtmlOptions'=>array('class'=>'blue pill full-width'),
 					'removeTemplate'=>'{link}',
 					'removeLabel'=>Yii::t('ui','Delete'),
 					//'removeHtmlOptions'=>array('class'=>'span1'),
					'removeCssClass'=>'',
					//'addCssClass'=>'',
					
 ));
//*/ ?>
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? utf8_encode(Yii::t('app', 'formCreate', array(), 'i18n')) : utf8_encode(Yii::t('app', 'formSave', array(), 'i18n'))); ?>
<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->