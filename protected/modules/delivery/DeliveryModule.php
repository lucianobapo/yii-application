<?php

class DeliveryModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'delivery.models.*',
			'delivery.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here

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
                'label' => Helpers::t ( 'app', 'Criar Pedido' ),
                'url' => $controller->createUrl ( '/' . Helpers::getModuleName()  . '/deliveryPedido/create' ),
                'visible' => Yii::app ()->user->checkAccess ( 'deliveryPedidos' ),
                'itemOptions' => array (
                    'class' => 'sa1 va1'.($controller->id.$action->id == 'deliveryPedidocreate' ? ' active' : ''),
                ),
                'linkOptions' => array (
                    "data-description" => "delivery"
                )
            ) );

            Yii::app()->menu->addMenu(array (
                'label' => Helpers::t ( 'app', 'Meus Pedidos' ),
                'url' => $controller->createUrl ( '/' . Helpers::getModuleName()  . '/deliveryPedido/list' ),
                'visible' => Yii::app ()->user->checkAccess ( 'deliveryPedidos' ),
                'itemOptions' => array (
                    'class' => 'sa1 va1'.($controller->id . $action->id == 'deliveryPedidolist' ? ' active' : ''),
                ),
                'linkOptions' => array (
                    "data-description" => "delivery"
                )
            ) );

            //*
            Yii::app()->menu->addMenu(array (
                'label' => Helpers::t ( 'appUi'.get_class($this), 'Meus Endereços' ),
                'url' => $controller->createUrl ( '/' . Helpers::getModuleName() . '/deliveryEndereco/create' ),
                'visible' => Yii::app ()->user->checkAccess ( 'deliveryPedidos' ),
                'itemOptions' => array (
                    'class' => 'sa1 va1'.($controller->id . $action->id == 'deliveryEnderecocreate' ? ' active' : ''),
                ),
                'linkOptions' => array (
                    "data-description" => "address"
                )
            ));//*/

			return true;
		}
		else
			return false;
	}
}
