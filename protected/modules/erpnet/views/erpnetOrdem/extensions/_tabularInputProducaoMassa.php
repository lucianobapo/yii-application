<td>
	<?php //echo CHtml::activeTextField($model,"[$index]data_termino",array('class'=>'input-medium','value'=>date('d/m/Y',strtotime("+ $index days",mktime(null,null,null,date('m'),1,date('Y')) ) ))); 
	//*
	$this->widget ( 'zii.widgets.jui.CJuiDatePicker', array (
		'model' => $model,
		'attribute' => "[$index]data_termino",
		//'value' => $model->data_termino,
		'language'=>'pt',//Yii::app()->getLanguage(),
		// additional javascript options for the date picker plugin
		'options' => array (
			'showAnim' => 'fold',
			'showButtonPanel' => false,
			'autoSize' => true,
		),
		'htmlOptions'=>array(
			'class'=>'input-medium',
			'value'=>Yii::app()->dateFormatter->formatDateTime(  strtotime("+ $index days",strtotime("-1 month",mktime(null,null,null,date('m'),1,date('Y'))) )  ,'medium',null),
		),
	) );//*/
	?>
	<?php echo CHtml::error($model,"[$index]data_termino"); ?>
</td>

<td>
	<?php echo CHtml::activeTextField($model,"[$index]quantidade",array('class'=>'input-small')); ?>
	<?php echo CHtml::error($model,"[$index]quantidade"); ?>
	<?php echo CHtml::activeHiddenField($model,"[$index]empresa",array('value'=>Yii::app()->user->empresa)); ?>
	<?php echo CHtml::activeHiddenField($model,"[$index]usuario",array('value'=>Yii::app()->user->name)); ?>
	<?php echo CHtml::activeHiddenField($model,"[$index]tipo",array('value'=>'producao')); ?>
</td>