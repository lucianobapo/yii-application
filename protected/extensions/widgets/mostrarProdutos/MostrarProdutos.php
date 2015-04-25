<?php
class MostrarProdutos extends CWidget {
	public function run() {
		Yii::import('application.modules.erpnet.models.ErpnetProduto');
		
		$destaques=ErpnetProduto::getDestaque();
		//$destaques=ErpnetProduto::model()->findAllByAttributes(array('empresa'=>'ilhanet','destaque'=>1));
		//echo '<pre>'.CVarDumper::dumpAsString($destaques).'</pre>';
?>

<div class="row-fluid">
<?php 
		foreach($destaques as $destaque) {
			
			?>
        		<div class="span6">
                <div class="square-background clearfix">
                                  
                  	<div class="square square-back pull-left"  style="width: 60px">
                		<img src="<?php echo Yii::app()->baseUrl . '/images/'.$destaque->id;?>.png" alt="" class="">
                     </div>
                  
                  <h4><?php echo $destaque->descricao;?></h4>
                  <div class="controls-row">
                  	<p class="span5"><?php echo Helpers::t('appUi', 'Valor unitário: ').CHtml::encode(Yii::app()->numberFormatter->formatCurrency($destaque->valor,'R$'));?></p>
                  	
                  </div>
                </div>
                </div>
			<?php 
		}
?>
</div>

<?php 	
	}
}
?>