<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Graphs & Charts';
$this->breadcrumbs=array(
	'Graphs & Charts',
);

$this->renderPartial('angularRelatorioGraficos', array());

?>
<div class="page-header">
  <h1>Graphs &amp; Charts - <small>Flot and Sparkline</small></h1>
</div>

<div ng-app='app'>
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title'=>"<i class='icon-check'></i> Despesas e Receitas - Delivery 24hs",
        ));

        ?>
        <div class="graficoLinha" style="height: 250px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
        <?php $this->endWidget();?>

</div>