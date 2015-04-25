<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

echo utf8_encode('

<h2>Desenvolvimento de software</h2>

<p>Aplicações robustas para o seu negócio.</p>

');
//var_dump(dirname(__FILE__));
//echo Helpers::getQuoteBRL(strtotime("-11 days"),'USD',0);
echo utf8_encode('<p>Cotação do dólar: '.Helpers::getQuoteBRL(time()).'</p>');
//echo Helpers::getQuoteBRL(time());


$persons=array(
		User::model()->findbyPk(1),
		User::model()->findbyPk(2)
);
/*
$this->widget('ext.widgets.tabularinput.XTabularInput',array(
		'models'=>$persons,
		'inputView'=>'extensions/_tabularInput',
		'inputUrl'=>$this->createUrl('request/addTabularInputs'),
		'removeTemplate'=>'<div class="action">{link}</div>',
		'addTemplate'=>'<div class="action">{link}</div>',
));
//*/
/*
$this->widget('ext.widgets.tabularinput.XTabularInput',array(
		'models'=>$persons,
		'containerTagName'=>'table',
		'headerTagName'=>'thead',
		'header'=>'
			<tr>
				<td>'.CHtml::activeLabelEX(User::model(),'username').'</td>
				<td>'.CHtml::activeLabelEX(User::model(),'email').'</td>
				<td></td>
			</tr>
		',
		'inputContainerTagName'=>'tbody',
		'inputTagName'=>'tr',
		'inputView'=>'extensions/_tabularInputAsTable',
		'inputUrl'=>$this->createUrl('request/addTabularInputsAsTable'),
		'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
		'addLabel'=>Yii::t('ui','Add new row'),
		'addHtmlOptions'=>array('class'=>'blue pill full-width'),
		'removeTemplate'=>'<td>{link}</td>',
		'removeLabel'=>Yii::t('ui','Delete'),
		'removeHtmlOptions'=>array('class'=>'red pill'),
));
//*/
?>