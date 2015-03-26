<?php

class HelpersDynamic {

	public $menus = array ();

	public function init(){
		//stub
	}

	public function addMenu($item=null){
		array_push ( $this->menus, $item);
	}

	public function renderMenu(){
		//stub
		$contr=new Controller('default');
		$this->getArrayMenu();
		$contr->widget ( 'zii.widgets.CMenu', array (
			// 'htmlOptions' => array( 'class' => 'nav' ),
			'activeCssClass' => 'active',

			'htmlOptions' => array (
				'class' => 'nav navbar-nav sb28'
			),
			'submenuHtmlOptions' => array (
				'class' => 'dropdown-menu'
			),
			'itemCssClass' => 'item-align',
			'encodeLabel' => false,

			'items' => $this->menus,
		) );
	}

	public function getArrayMenu() {

		$menus = &$this->menus;
		$moduleName=Helpers::getModuleName();
		$contr=new Controller('default');

        if ((isset ( Yii::app ()->modules [$moduleName] )) && ($moduleName != 'delivery')) {
            if (isset ( Yii::app ()->modules [$moduleName] ))
                array_push ( $menus, array (
                    'label' => Helpers::t ( 'app', 'menuTopIndex' ),
                    'url' => Yii::app()->homeUrl,
                    'linkOptions'=>array("data-description"=>"our home page"),
                    'itemOptions' => array (
                        'class' => ('sa1 va1'.(Yii::app ()->controller->action->id == 'index' ? ' active' : ''))
                    ),
                ) );
            else
                array_push ( $menus, array (
                    'label' => Helpers::t ( 'app', 'menuTopIndex' ),
                    'url' => Yii::app()->homeUrl ,
                    'linkOptions'=>array("data-description"=>"our home page"),
                    'itemOptions' => array (
                        'class' => 'sa1 va1'.(Yii::app ()->controller->action->id == 'index' ? ' active' : '')
                    ),
                ) );
        }



		// array_push($menus,array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')));
		/*
		array_push ( $menus, array (
				'label' => 'Contact',
				'url' => array (
						'/site/contact'
				)
		) );*/

		if ((isset ( Yii::app ()->modules [$moduleName] )) && ($moduleName == 'ndtreport')) {

			if (isset ( Yii::app ()->modules ['gii'] ))
				array_push ( $menus, array (
					'label' => 'Gii',
					'url' => array (
						'/gii'
					),
					'visible' => Yii::app ()->user->checkAccess ( 'accessGii' )
				) );

			array_push ( $menus, array (
				'label' => 'Manage Message',
				'url' => array (
					'/sourcemessage'
				),
				'visible' => Yii::app ()->user->checkAccess ( 'manageMessage' )
			) );

			array_push ( $menus, array (
				'label' => 'Manage Authitem',
				'url' => array (
					'/authitem'
				),
				'visible' => Yii::app ()->user->checkAccess ( 'manageAuth' )
			) );

			array_push ( $menus, array (
				'label' => Helpers::t ( 'app', 'menuTopConfig' ),
				'url' => array (
					'/' . $moduleName . '/reportConfTipoRelatorio/config'
				),
				'visible' => Yii::app ()->user->checkAccess ( 'manageConfig' )
			) );
			array_push ( $menus, array (
				'label' => Helpers::t ( 'app', 'menuTopCliente' ),
				'url' => array (
					'/' . $moduleName . '/reportCliente'
				),
				'visible' => Yii::app ()->user->checkAccess ( 'manageCliente' )
			) );
			array_push ( $menus, array (
				'label' => Helpers::t ( 'app', 'menuTopBook'),
				'url' => array (
					'/' . $moduleName . '/reportBook'
				),
				'visible' => Yii::app ()->user->checkAccess ( 'manageBook' )
			) );
			array_push ( $menus, array (
				'label' => Helpers::t ( 'app', 'menuTopRelatorios'),
				'url' => array (
					'/' . $moduleName . '/reportRelatorios/admin'
				),
				'visible' => Yii::app ()->user->checkAccess ( 'manageRelatorios' )
			) );
		}
		if ((isset ( Yii::app ()->modules [$moduleName] )) && ($moduleName == 'webcomex')) {
			array_push ( $menus, array (
				'label' => Helpers::t ( 'comex', 'menuTopEmbarque' ),
				'url' => array (
					'/' . $moduleName . '/comexEmbarque/admin'
				),
				'visible' => Yii::app ()->user->checkAccess ( 'comexManageEmbarque' )
			) );
		}
		//*
		if ((isset ( Yii::app ()->modules [$moduleName] )) && ($moduleName == 'erpnet')) {

            array_push ( $menus, array (
                'label' => 'Quest',
                'url' => array (
                    '/erpnetQuestionario'
                ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageQuest' )
            ) );
/*
            array_push ( $menus,

				array (
					'label' => Helpers::t ( 'erpnet', 'menuTopCadastros') . ' <span class="caret"></span>',
					'url' => '#',
					'itemOptions' => array (
						'class' => 'dropdown',
						'tabindex' => "-1"
					),
					'linkOptions' => array (
						'class' => 'dropdown-toggle',
						'data-toggle' => "dropdown"
					),
					'items' => array (
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopProdutos'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetProduto/admin' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageProdutos' )
						),
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopGrupos' ),
							'url' => $contr->createUrl ( '/' . $moduleName  . '/erpnetGrupoProduto/admin' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageProdutos' )
						),
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopWbs'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetWbs/create' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageWbs' )
						),
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopCliente'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetCliente/admin' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageCliente' )
						)
					)
				,
					'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewCadastros' )
				),
                array (
					'label' => Helpers::t ( 'erpnet', 'menuTopLancamentos' ) . ' <span class="caret"></span>',
					'url' => '#',
					'itemOptions' => array (
						'class' => 'dropdown',
						'tabindex' => "-1"
					),
					'linkOptions' => array (
						'class' => 'dropdown-toggle',
						'data-toggle' => "dropdown"
					),
					'items' => array (
						// array('label'=>utf8_encode(Yii::t('erpnet', 'menuTopOrdemProducao', array(), 'i18n')), 'url'=>$contr->createUrl('/'.$this->getModuleName().'/erpnetOrdem/create'),'visible'=>Yii::app()->user->checkAccess('erpnetManageOrdem')),
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopOrdemProducao2' ),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetOrdem/createProducaoMassa' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageOrdem' )
						),

						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopOrdemVenda'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetOrdem/createVenda' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageOrdemVenda' )
						),
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopOrdemCompra' ),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetOrdem/createCompra' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageOrdemCompra' )
						),

						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopOrdemServico'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetOrdem/createServico' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetCreateOrdemServico' )
						),
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopOrdemConsumo' ),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetOrdem/createConsumo' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetCreateOrdemConsumo' )
						),

						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopOrcamentoServico'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetOrdem/createOrcamentoServico' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetCreateOrcamentoServico' )
						),

						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopAjuste'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetEstoque/create' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageAjuste' )
						),
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopFatura'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetFatura/create' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageFatura' )
						),
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopMargem'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetMargem/create' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageMargem' ),
						),
					)
				,
					'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewLancamentos' )
				),

                array (
					'label' => Helpers::t ( 'erpnet', 'menuTopRelatorios') . ' <span class="caret"></span>',
					'url' => '#',
					'itemOptions' => array (
						'class' => 'dropdown',
						'tabindex' => "-1"
					),
					'linkOptions' => array (
						'class' => 'dropdown-toggle',
						'data-toggle' => "dropdown"
					),
					'items' => array (
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopProducaoProduto'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetRelatorios/relatorioTanque' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewRelatorioTanque' )
						),
						array (
							'label' => Helpers::t ( 'erpnet', 'menuTopContas'),
							'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetRelatorios/relatorioContas' ),
							'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewRelatorioContas' )
						)
					),
					'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewRelatorios' )
				) );//*/
		}


		if (($moduleName != 'delivery'))
			array_push ( $menus, array (
				'label' => Helpers::t ( 'app', 'login'),
				'url' => $contr->createUrl ( '/site/execLogin' ),
				'visible' => Yii::app ()->user->isGuest,
				'itemOptions'=>array('class'=>(Yii::app()->controller->action->id=='execLogin' ? 'active':'')),
				'linkOptions'=>array("data-description"=>"member area"),
			) );

		if ((isset ( Yii::app ()->modules [$moduleName] )) && ($moduleName == 'erpnet')) {

			$items = array (
				array (
					'label' => Helpers::t ( 'erpnet', 'menuTopTrocarSenha'),
					'url' => $contr->createUrl ( '/site/trocaSenha' ),
					'visible' => ! Yii::app ()->user->isGuest
				),
				array (
					'label' => Helpers::t ( 'erpnet', 'menuTopConfig'),
					'url' => $contr->createUrl ( '/' . $moduleName . '/erpnetConfig' ),
					'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageConfig' )
				),
				array (
					'label' => Helpers::t ( 'erpnet', 'menuTopSuporte'),
					'url' => array ('/site/contact'),
					//'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageConfig' )
				),
				array (
					'label' => Helpers::t ( 'app', 'logout'),
					'url' => $contr->createUrl ( '/site/logout' ),
					'visible' => ! Yii::app ()->user->isGuest
				),

				array (
					'label' => 'Manage User',
					'url' => $contr->createUrl ( '/user' ),
					'visible' => Yii::app ()->user->checkAccess ( 'manageUser' )
				),
				array (
					'label' => 'Forms',
					'url' => array (
						'/site/page',
						'view' => 'forms'
					),
					'visible' => Yii::app ()->user->checkAccess ( 'admin' )
				),
				array (
					'label' => 'Tables',
					'url' => array (
						'/site/page',
						'view' => 'tables'
					),
					'visible' => Yii::app ()->user->checkAccess ( 'admin' )
				),
				array (
					'label' => 'Interface',
					'url' => array (
						'/site/page',
						'view' => 'interface'
					),
					'visible' => Yii::app ()->user->checkAccess ( 'admin' )
				),

				array (
					'label' => 'Manage Sourceessage',
					'url' => $contr->createUrl ( '/sourcemessage' ),
					'visible' => Yii::app ()->user->checkAccess ( 'manageMessage' )
				),
				array (
					'label' => 'Manage Message',
					'url' => $contr->createUrl ( '/message' ),
					'visible' => Yii::app ()->user->checkAccess ( 'manageMessage' )
				),
				array (
					'label' => 'Manage Authitem',
					'url' => $contr->createUrl ( '/authitem' ),
					'visible' => Yii::app ()->user->checkAccess ( 'manageAuth' )
				),
				array (
					'label' => 'Manage Authassignment',
					'url' => $contr->createUrl ( '/authassignment' ),
					'visible' => Yii::app ()->user->checkAccess ( 'manageAuth' )
				),
				array (
					'label' => 'Manage Authitemchild',
					'url' => $contr->createUrl ( '/authitemchild' ),
					'visible' => Yii::app ()->user->checkAccess ( 'manageAuth' )
				)
			);
			if (isset ( Yii::app ()->modules ['gii'] ))
				array_push ( $items, array (
					'label' => 'Gii',
					'url' => $contr->createUrl ( '/gii' ),
					'visible' => Yii::app ()->user->checkAccess ( 'accessGii' )
				) );

			array_push ( $menus, array (
				'label' => Helpers::t ( 'erpnet', 'menuTopMinhaConta') . ' (' . Yii::app ()->user->name . ')' . ' <span class="caret"></span>',
				'url' => '#',
				'itemOptions' => array (
					'class' => 'dropdown',
					'tabindex' => "-1"
				),
				'linkOptions' => array (
					'class' => 'dropdown-toggle',
					'data-toggle' => "dropdown"
				),
				'items' => $items,
				'visible' => ! Yii::app ()->user->isGuest
			) );
		} else
			array_push ( $menus, array (
				'label' => Helpers::t ( 'app', 'logout') . ' (' . Yii::app ()->user->name . ')',
				'url' => array (
					'/site/logout'
				),
				'visible' => ! Yii::app ()->user->isGuest
			) );
		//*/
		// *

	}
}
