<?php
/* @var $this ErpnetRelatoriosController */
?>


<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>utf8_encode(Yii::t('erpnetUi', 'viewRelatorioTabelaProducao', array(), 'i18n')),
		));
		if (isset($subtitle)) 
			echo $subtitle;
		$gridDataProvider->setPagination(false);
		$this->widget('zii.widgets.grid.CGridView', array(
			//'type'=>'striped bordered condensed',
			'itemsCssClass'=>'table table-hover table-striped table-bordered table-condensed',
			'dataProvider'=>$gridDataProvider,
			'template'=>"{items}",
			'columns'=>$itens,
			
		));
		$this->endWidget();
		
		echo $obs;
?>
