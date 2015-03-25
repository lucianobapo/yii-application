<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title pull-left">{{painel.painelTitle}}</h3>
		<div class="btn-toolbar pull-right">
			<div class="btn-group btn-group-xs">
				<button type="button" class="btn btn-default" title="<?php echo Helpers::t('appUi','Ordenar por Nome do Produto'); ?>" ng-click="predicate = 'descricao'; reverse=!reverse; reverse?alterna='':alterna='-alt';"><i ng-class="(predicate == 'descricao' && reverse)?alterna='':alterna='-alt'; 'glyphicon glyphicon-sort-by-alphabet'+alterna"></i></button>
				<button type="button" class="btn btn-default" title="<?php echo Helpers::t('appUi','Ordenar por Preço do Produto'); ?>" ng-click="predicate = 'itemValor'; reverse=!reverse; reverse?alterna='':alterna='-alt';"><i ng-class="(predicate == 'itemValor' && reverse)?alterna='':alterna='-alt'; 'glyphicon glyphicon-sort-by-order'+alterna"></i></button>
				<button type="button" class="btn btn-default" title="<?php echo Helpers::t('appUi','Ordenar por Preferência do Produto'); ?>" ng-click="predicate = 'preferencia'; reverse=!reverse; reverse?alterna='':alterna='-alt';"><i ng-class="(predicate == 'preferencia' && reverse)?alterna='':alterna='-alt'; 'glyphicon glyphicon-sort-by-attributes'+alterna"></i></button>
				<button type="button" ng-click="layout='block-delivery';" class="btn btn-default" title="<?php echo Helpers::t('appUi','Mostrar Produtos em Blocos'); ?>"><i class="glyphicon glyphicon-th-large"></i></button>
				<button type="button" ng-click="layout='span-delivery';" class="btn btn-default" title="<?php echo Helpers::t('appUi','Mostrar Produtos em Lista'); ?>"><i class="glyphicon glyphicon-th-list"></i></button>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<ul class="list-inline-delivery" ng-init="layout='block-delivery'; predicate = ['-promocao','descricao']; reverse=false; alterna='-alt';">
			<li ng-class="layout" ng-repeat="produto in painel.produtos | orderBy:predicate:reverse">
				<div itemscope itemtype="http://data-vocabulary.org/Product">
					<img class="pull-right" ng-show="produto.promocao && layout=='span-delivery'" ng-src="/images/promocao.png" alt="{{produto.promocaoTexto}}">
					<div class="block-delivery-image span-delivery-image">
						<div ng-class="produto.promocao? 'block-delivery-image-promocao':''">
							<img class="sim2" itemprop="image" ng-src="{{produto.imagem_thumb}}" alt="{{painel.altBreak(produto.preDescricao+produto.descricao)}}" title="{{produto.descricao}}">
						</div>
					</div>

					<h4 class="st4 vt4" itemprop="name">{{produto.descricao}}</h4>

					<div class="sb33 vb33">
						{{produto.codLabel}}: <span itemprop="identifier" content="mpn:{{produto.id_produtoValor}}">{{produto.id_produtoValor}}</span> - <span itemprop="brand">{{produto.marca}}</span>
					</div>
					<div class="sb33 vb33">
						{{produto.categoriaLabel}}: <span itemprop="category" content="{{produto.categoriaContent}}">{{produto.categoriaTexto}}</span>
					</div>
					<div class="sb33 vb33" ng-hide="produto.preferencia==0" itemprop="review" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
						{{produto.preferenciaLabel}}:
						<div class="progress sb31" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
							<meta itemprop="best" content="100"/>
							<div class="progress-bar vb31" role="progressbar" aria-valuenow="{{produto.preferencia}}" aria-valuemin="0" aria-valuemax="100" style="width: {{produto.preferencia}}%;"></div>
							<div class="sb32 vb32"><span itemprop="value">{{produto.preferencia}}</span>%</div>
						</div> {{produto.preferenciaLabel2}} <span itemprop="count">{{produto.preferenciaTotal}}</span>
					</div>

					<div class="sb8" itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
						<span class="sb9 vb9b" ng-show="painel.moduleItems.mostrarValor && produto.promocao">
							{{produto.textoValorOld}} {{produto.valorOld}}
						</span>
						<span class="sb9 vb9a" ng-show="painel.moduleItems.mostrarValor">
							{{produto.textoValor}} R$<span itemprop="price">{{produto.valor}}</span>
						</span>
					</div>

					<em class="{{produto.availabilityClass}}" itemprop="availability" content="{{produto.availabilityContent}}">{{produto.availabilityTexto}}</em>

					<input type="number" name="{{produto.quantidadeName}}"
						   class="numbersOnly sip1"
						   maxlength="2"
						   min="0"
						   max="{{produto.estoque}}"
						   ng-hide="painel.moduleItems.hide || produto.soldOut"
						   ng-model="produto.quantidade" required style="">
					<input type="hidden" name="{{produto.id_produtoName}}" value="{{produto.id_produtoValor}}">

					<spam ng-hide="painel.moduleItems.hide || produto.soldOut" class="label label-success vl1"><i class="fa fa-truck sl1"></i>{{painel.freteText}}</spam>
<!--
					<p ng-class="'produto-btn'" ng-show="false">
						<button ng-class="'btn btn-default btn-small btn-sm btn-success'" type="button"><i class="icon-shopping-cart icon-white glyphicon glyphicon-shopping-cart glyphicon-white"></i> Adicionar</button>
					</p>
-->
					<blockquote class="sb11 vb11" itemprop="description">{{produto.obs}}</blockquote>
				</div>

			</li>
		</ul>
	</div>
</div>


