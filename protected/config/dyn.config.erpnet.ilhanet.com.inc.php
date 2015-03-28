<?php
// Configura os Menus

Yii::app()->menu->addMenu(
    array (
        'label' => Helpers::t ( 'erpnet', 'menuTopCadastros') . ' <span class="caret"></span>',
        'url' => '#',
        'itemOptions' => array (
            'class' => "'dropdown'",
            'tabindex' => "-1"
        ),
        'linkOptions' => array (
            'class' => 'dropdown-toggle',
            'data-toggle' => "dropdown"
        ),
        'items' => array (
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopProdutos'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetProduto/admin' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageProdutos' )
            ),
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopGrupos' ),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName()  . '/erpnetGrupoProduto/admin' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageProdutos' )
            ),
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopWbs'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetWbs/create' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageWbs' )
            ),
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopCliente'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetCliente/admin' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageCliente' )
            )
        ),
        'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewCadastros' )
    )
);

Yii::app()->menu->addMenu(
    array (
        'label' => Helpers::t ( 'erpnet', 'menuTopLancamentos' ) . ' <span class="caret"></span>',
        'url' => '#',
        'itemOptions' => array (
            'class' => "'dropdown'",
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
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetOrdem/createProducaoMassa' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageOrdem' )
            ),

            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopOrdemVenda'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetOrdem/createVenda' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageOrdemVenda' )
            ),
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopOrdemCompra' ),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetOrdem/createCompra' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageOrdemCompra' )
            ),

            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopOrdemServico'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetOrdem/createServico' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetCreateOrdemServico' )
            ),
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopOrdemConsumo' ),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetOrdem/createConsumo' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetCreateOrdemConsumo' )
            ),

            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopOrcamentoServico'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetOrdem/createOrcamentoServico' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetCreateOrcamentoServico' )
            ),

            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopAjuste'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetEstoque/create' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageAjuste' )
            ),
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopFatura'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetFatura/create' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageFatura' )
            ),
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopMargem'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetMargem/create' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetManageMargem' ),
            ),
        )
    ,
        'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewLancamentos' )
    )
);

Yii::app()->menu->addMenu(
    array (
        'label' => Helpers::t ( 'erpnet', 'menuTopRelatorios') . ' <span class="caret"></span>',
        'url' => '#',
        'itemOptions' => array (
            'class' => "'dropdown'",
            'tabindex' => "-1"
        ),
        'linkOptions' => array (
            'class' => 'dropdown-toggle',
            'data-toggle' => "dropdown"
        ),
        'items' => array (
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopProducaoProduto'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetRelatorios/relatorioTanque' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewRelatorioTanque' )
            ),
            array (
                'label' => Helpers::t ( 'erpnet', 'menuTopContas'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetRelatorios/relatorioContas' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewRelatorioContas' )
            ),
            array (
                'label' => Helpers::t ( 'erpnet', 'Relatórios Gráficos'),
                'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/erpnetRelatorios/graficos' ),
                'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewRelatorioContas' )
            )
        ),
        'visible' => Yii::app ()->user->checkAccess ( 'erpnetViewRelatorios' )
    )
);