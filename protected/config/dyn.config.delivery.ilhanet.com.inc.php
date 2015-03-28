<?php
// Configura os Menus

/*
            Yii::app()->menu->addMenu(array (
            'label' => Helpers::t ( 'app', 'Registro' ),
            'url' => $contr->createUrl ( '/' . Helpers::getModuleName()  . '/userRegister/create' ),
            'visible' => ( (Yii::app ()->user->isGuest)&&(isset(Yii::app()->user->dados)) ),
            'itemOptions' => array (
                'ng-class'=>"active=='register'?'active':''",
                'ng-click'=>"active='register'",
                'class' => 'sa1 va1'//.(Yii::app ()->controller->id.Yii::app ()->controller->action->id == 'userRegistercreate' ? ' active' : '')
            ),
            'linkOptions' => array (
                "data-description" => "new users"
            )
        ) );//*/

Yii::app()->menu->addMenu(array (
    'label' => Yii::app()->menu->getController().Helpers::t ( 'app', 'Criar Pedido' ),
    'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName()  . '/deliveryPedido/create' ),
    'visible' => Yii::app ()->user->checkAccess ( 'deliveryPedidos' ),
    'itemOptions' => array (
        'class' => "(Yii::app()->menu->getController() . Yii::app()->menu->getAction() == 'deliveryPedidocreate' ? 'sa1 va1 active' : 'sa1 va1')",
    ),
    'linkOptions' => array (
        "data-description" => "delivery"
    )
) );

//CButtonColumn::
//evaluateExpression::

Yii::app()->menu->addMenu(array (
    'label' => Helpers::t ( 'app', 'Meus Pedidos' ),
    'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName()  . '/deliveryPedido/list' ),
    'visible' => Yii::app ()->user->checkAccess ( 'deliveryPedidos' ),
    'itemOptions' => array (
        'class' => "(Yii::app()->menu->getController() . Yii::app()->menu->getAction() == 'deliveryPedidolist' ? 'sa1 va1 active' : 'sa1 va1')",
    ),
    'linkOptions' => array (
        "data-description" => "delivery"
    )
) );

//*
Yii::app()->menu->addMenu(array (
    'label' => Helpers::t ( 'appUi'.get_class($this), 'Meus Endereços' ),
    'url' => Yii::app()->createUrl ( '/' . Helpers::getModuleName() . '/deliveryEndereco/create' ),
    'visible' => Yii::app ()->user->checkAccess ( 'deliveryPedidos' ),
    'itemOptions' => array (
        'class' => "(Yii::app()->menu->getController() . Yii::app()->menu->getAction() == 'deliveryEnderecocreate' ? 'sa1 va1 active' : 'sa1 va1')",
    ),
    'linkOptions' => array (
        "data-description" => "address"
    )
));//*/