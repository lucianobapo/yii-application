<script type="text/javascript">
	moduleItems = {
		hide: true,
		mostrarValor: <?php echo ((!Yii::app ()->user->isGuest) ? 'true':'true'); ?>,
		mostrarAlerta: false

	};

	painelTitle = "<?php echo Helpers::t('appUi', 'Destaques'); ?>";

	produtos = [
		<?php
    		$data= new DbAccess();
    		$erpnet=Yii::app()->getModule('erpnet');
    		$index=0;
    		foreach ($data->getErpnetProdutos(true) as $produto):
				$saldo=ErpnetProduto::saldoEstoque($produto->id);
				if ($saldo==0) continue;
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
			id_produtoValor: "<?php echo $produto->id;?>",

			index: <?php echo $index; ?>,

			quantidade: 0
		},
		<?php $index=$index+1; endforeach; ?>

	];

</script>