<?php
class MostrarProdutosOrdem extends CWidget {
	
	public $id=null;
	
	public function run() {
		Yii::import('application.modules.erpnet.models.ErpnetProduto');
		Yii::import('application.modules.erpnet.models.ErpnetOrdem');
		Yii::import('application.modules.erpnet.models.ErpnetOrdemItem');
		
		$itens=ErpnetOrdemItem::model()->findAllByAttributes(array('id_ordem'=>$this->id));
		$pedido=ErpnetOrdem::model()->findByPk($this->id);
		
		//echo '<pre>'.CVarDumper::dumpAsString($itens).'</pre>';
?>
        <p><?php echo Helpers::t('appUi', '{data} - Valor total: {valor}',array('{data}'=>Yii::app()->dateFormatter->formatDateTime($pedido->data_termino,'medium',null),'{valor}'=>CHtml::encode(Yii::app()->numberFormatter->formatCurrency($pedido->valor,'R$')) )); ?></p>

        <p><b><?php
                if ($pedido->pagamento=='vistad')
                    echo Helpers::t('appUi', 'Pagamento em dinheiro. Troco para: {valor}',array('{valor}'=>CHtml::encode(Yii::app()->numberFormatter->formatCurrency($pedido->troco,'R$')) ));
                if ($pedido->pagamento=='vistacd')
                    echo Helpers::t('appUi', 'Pagamento com Cartão de Débito.');
                if ($pedido->pagamento=='vistacc')
                    echo Helpers::t('appUi', 'Pagamento com Cartão de Crédito.');
                ?></b></p>

<div class="row-fluid">
<?php 
		$index=0;
		$mudacoluna= (count($itens)+(count($itens) % 2))/2;
		foreach($itens as $item) {
			$produto=ErpnetProduto::model()->findByPk($item->id_produto);
			if (($index % $mudacoluna)==0) echo '<div class="span6">';
			?>
                <div class="square-background clearfix">
                                  
                  	<div class="square square-back pull-left"  style="width: 60px">
                		<img src="<?php echo  Helpers::getThumbnail(Yii::app()->baseUrl . '/images/'.$produto->id.'.png');?>" alt="<?php echo $produto->descricao; ?>" class="">
                     </div>
                  
                  <h4><?php echo $produto->descricao;?></h4>
                  <div class="controls-row">
                  	<p class="span5"><?php echo Helpers::t('appUi', 'Pedido: {quant} x ',array('{quant}'=>$item->quantidade)).CHtml::encode(Yii::app()->numberFormatter->formatCurrency($item->valor,'R$'));?></p>
                  	
                  </div>
                </div>
               
			<?php 
			if ( (($index % $mudacoluna)==$mudacoluna-1)|| (count($itens)-1==$index) ) echo '</div>';
			$index=$index+1;
		}
?>
</div>

<?php 	
	}
}
?>