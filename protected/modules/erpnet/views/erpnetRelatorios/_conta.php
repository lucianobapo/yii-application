<?php
/* @var $this ErpnetRelatoriosController */
?>

<p>Saldo <?php echo $saldo; ?></p>

<?php
	//$gridDataProvider = new CArrayDataProvider ( array() );

		$gridDataProvider->setPagination(false);
		$this->widget('zii.widgets.grid.CGridView', array(
			//'type'=>'striped bordered condensed',
			'itemsCssClass'=>'table table-hover table-striped table-bordered table-condensed',
			'dataProvider'=>$gridDataProvider,
			'template'=>"{items}",
			'columns'=>$itens,
			//'enablePagination'=>false,
		));
		
?>