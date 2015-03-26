<?php
/* @var $this ErpnetOrdemController */
/* @var $gridDataProvider CActiveDataProvider */

$this->beginWidget ( 'zii.widgets.CPortlet', array (
		'title' => $title,
) );

$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'erpnet-ordem-grid',
		'itemsCssClass' => 'table table-striped table-bordered table-hover',
		'dataProvider' => $gridDataProvider,
		'template' => "{items}",
		'columns' => array (
				array (
						'name' => 'data_termino',
						'header' => 'Data',
						'value' => 'Yii::app()->dateFormatter->formatDateTime($data->data_termino,"medium",null)' 
						//'value' => 'Yii::app()->dateFormatter->format(\'dd-mm-yyyy\',$data->data_termino)'
				),
				array (
						'name' => 'referencia',
						'header' => 'Referencia' 
				),
				array (
						'class' => 'CButtonColumn',
						'buttons' => array (
								'update' => array (
										'url' => 'Yii::app()->createUrl(Helpers::getModuleName()."/erpnetOrdem/'.$actionUpdate.'", array("id"=>$data->id))' 
								),
								'delete' => array (
										'visible' => false 
								),
								'view' => array (
										'visible' => false 
								) 
						) 
				) 
		) 
) );
$this->endWidget ();

//echo Yii::app()->locale->dateFormat;
?>
