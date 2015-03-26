<?php
/* @var $this ErpnetComprasController */
/* @var $model ErpnetCompras */

$this->breadcrumbs=array(
	'Ordem de Compra'=>array('admin'),
	utf8_encode(Yii::t('app', 'breadCreate', array(), 'i18n')),
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'menuList', array(), 'i18n'), 'url'=>array('index')),
	array('label'=>utf8_encode(Yii::t('app', 'menuManage', array(), 'i18n')), 'url'=>array('admin')),
);
?>

<h3><?php echo utf8_encode(Yii::t('erpnet', 'Criar Ordem de Compra', array(), 'i18n'));?></h3>

<?php $this->renderPartial('_form2', array('model'=>$model)); 

/*
 $this->widget('ext.widgets.tabularinput.XTabularInput',array(
 		'models'=>$model,
 		'containerTagName'=>'table',
 		'headerTagName'=>'thead',
 		'header'=>'
 		<tr>
 		<td>'.CHtml::activeLabelEX(User::model(),'num_ordem').'</td>
 		<td>'.CHtml::activeLabelEX(User::model(),'data_emissao').'</td>
 		<td>'.CHtml::activeLabelEX(User::model(),'moeda').'</td>
 		<td>'.CHtml::activeLabelEX(User::model(),'conversao_brl').'</td>
 		<td>'.CHtml::activeLabelEX(User::model(),'incoterm').'</td>
 		<td>'.CHtml::activeLabelEX(User::model(),'incoterm_local').'</td>
 		<td></td>
 		</tr>
 		',
 		'inputContainerTagName'=>'tbody',
 		'inputTagName'=>'tr',
 		'inputView'=>'extensions/_tabularInputAsTable',
 		'inputUrl'=>$this->createUrl('/request/addTabularInputsAsTable'),
 		'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
 		'addLabel'=>Yii::t('ui','Add new row'),
 		'addHtmlOptions'=>array('class'=>'blue pill full-width'),
 		'removeTemplate'=>'<td>{link}</td>',
 		'removeLabel'=>Yii::t('ui','Delete'),
 		'removeHtmlOptions'=>array('class'=>'red pill'),
 ));
//*/
?>