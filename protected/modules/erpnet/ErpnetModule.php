<?php

class ErpnetModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'erpnet.models.*',
			'erpnet.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			if ( (!Yii::app()->user->isGuest) && (($record=User::model()->findByAttributes(array('username'=>Yii::app()->user->name)))!==null) && ($record->trocar_senha==1) ){
				Yii::app()->user->setFlash('trocaSenha',utf8_encode(Yii::t('erpnetUi', 'viewTrocaSenhaFlash', array(), 'i18n')));
				Yii::app()->request->redirect(Controller::createUrl('/site/trocaSenha'));
			}
			return true;
		}
		else
			return false;
	}

}
