<?php
$erpnet=Yii::app()->getModule('erpnet');
$index=0;
?>

<script type="text/javascript">
	painelTitle = "<?php echo Helpers::t('appUi', 'Escolha os Produtos'); ?>";
	moduleItems = {
		hide: false,
		mostrarValor: true,
		mostrarAlerta: true,

		//trocoName: "",
		//trocoValor: "",

		id_clienteName: "<?php echo CHtml::activeName($modelOrdem, "id_cliente"); ?>",
		id_clienteValor: "<?php echo User::model()->findByAttributes(array('social_identifier'=>Yii::app()->user->social_identifier))->id_cliente; ?>",

		status_fechadoName:"<?php echo CHtml::activeName($modelOrdem, "status_fechado"); ?>",
		tipoName:"<?php echo CHtml::activeName($modelOrdem, "tipo"); ?>"
	};
	produtos = [
		<?php

			$modelProdutos= new DbAccess();
			foreach ($modelProdutos->getErpnetProdutos(false) as $produto):
				$saldo=ErpnetProduto::saldoEstoque($produto->id);
				$modelPreferencia= new DbAccess();
			?>
		{
			descricao: "<?php echo $produto->descricao;?>",
			preDescricao: "<?php echo Helpers::t('appUi','Imagem do produto:')?> ",
			categoriaContent: "<?php echo $produto->categoria;?>",
			categoriaTexto: "<?php echo ErpnetProduto::lastCategoria($produto->categoria);?>",
			marca: "<?php echo $produto->fabricante;?>",
			availabilityContent: "<?php echo ($saldo==0)?'out_of_stock':'in_stock'; ?>",
			availabilityTexto: "<?php echo ($saldo==0)?Helpers::t('appUi', 'Indisponível no momento',array(),'i18n',null,false):Helpers::t('appUi', 'Em estoque',array(),'i18n',null,false); ?>",
			availabilityClass: "sb10 <?php echo ($saldo==0)?'vb10a':'vb10b'; ?>",
			preferencia: <?php echo round(($modelPreferencia->getPreferencia()>0)?($modelPreferencia->getPreferencia($produto->id)*100)/$modelPreferencia->getPreferencia():'0'); ?>,
			preferenciaTotal: "<?php echo $modelPreferencia->getPreferencia(); ?>",
			preferenciaLabel: "<?php echo Helpers::t('appUi', 'Preferência',array(),'i18n',null,false);?>",
			preferenciaLabel2: "<?php echo Helpers::t('appUi', 'de',array(),'i18n',null,false);?>",
			categoriaLabel: "<?php echo Helpers::t('appUi', 'Categoria',array(),'i18n',null,false);?>",
			codLabel: "<?php echo Helpers::t('appUi', 'Cód.',array(),'i18n',null,false);?>",

			obs: "<?php echo $produto->obs;?>",
			imagem: "<?php echo Yii::app()->baseUrl . '/images/'.$produto->id.'.png';?>",
			imagem_thumb: "<?php echo Helpers::getThumbnail(Yii::app()->baseUrl . '/images/'.$produto->id.'.png');?>",
			valor: "<?php echo Yii::app()->numberFormatter->formatCurrency(( ($produto->promocao) ? $produto->valor_promocao:$produto->valor_venda),'');?>",
			valorOld: "<?php echo Yii::app()->numberFormatter->formatCurrency($produto->valor_venda,'R$');?>",
			itemValor: <?php echo ( ($produto->promocao) ? $produto->valor_promocao:$produto->valor_venda);?>,

			textoValor: "<?php echo Helpers::t('appUi', 'Por: ',array(),'i18n',null,false);?>",
			textoValorOld :"<?php echo Helpers::t('appUi', 'De: ',array(),'i18n',null,false);?>",

			promocao: <?php echo ( ($produto->promocao) ? 'true':'false'); ?>,
			promocaoTexto: "<?php echo Helpers::t('appUi','Promoção!') ?>",
			estoque: <?php echo $saldo; ?>,
			soldOut: <?php echo (($saldo>0) ? 'false':'true'); ?>,

			index: <?php echo $index; ?>,

			quantidadeName: "<?php echo is_object($modelItem[$index])?CHtml::activeName($modelItem[$index], "[$index]quantidade"):''; ?>",
			id_produtoName: "<?php echo is_object($modelItem[$index])?CHtml::activeName($modelItem[$index], "[$index]id_produto"):''; ?>",
			id_produtoValor: "<?php echo $produto->id;?>",

			quantidade: <?php if (is_object($modelItem[$index])) echo $modelItem[$index]->quantidade; else echo '0';?>
		},
		<?php $index=$index+1; endforeach; ?>

	];

	app.directive('createProductPanel', function() {
		return {
			restrict: 'E',
			//templateUrl: '/themes/delivery/views/layouts/create-product-panel.html',
			controller: function(){
				this.produtos = produtos;
				this.moduleItems = moduleItems;
				this.textoIndisponivel = "<?php echo Helpers::t('appUi', 'Indisponível no momento',array(),'i18n',null,false);?>";

				this.labelFormaPagamento = "<?php echo Helpers::t('appUi', 'Forma de Pagamento: '); ?>";
				//this.labelValorTotal = "";
				//this.labelTroco = "";
				//this.labelBreve = "";
				this.labelCarregando="<?php echo Helpers::t('app', 'Carregando...'); ?>";
				this.labelBtnEnviar="<?php echo Helpers::t('app', 'Enviar Pedido para Entrega'); ?>";

				this.labelPagSeguro="<?php echo Helpers::t('appUi', 'Pague com PagSeguro - é rápido, grátis e seguro!'); ?>";
				this.pagSeguro=<?php echo ((Yii::app()->params['pagseguro'])? 'true':'false'); ?>;

				this.getTotal  = function() {
					var total = 0;
					for(var i = 0; i < this.produtos.length; i++){
						var product = this.produtos[i];
						if (product.quantidade>0) total += (product.itemValor * product.quantidade);
					}
					return total;

				};


			},
			controllerAs: 'createCtrl'

		};
	});

</script>