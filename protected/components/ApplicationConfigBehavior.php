<?php

/**
 * ApplicationConfigBehavior is a behavior for the application.
 * It loads additional config parameters that cannot be statically
 * written in config/main
 */
class ApplicationConfigBehavior extends CBehavior
{
	/**
	 * Declares events and the event handler methods
	 * See yii documentation on behavior
	 */
	public function events()
	{
		return array_merge(parent::events(), array(
			'onBeginRequest'=>'beginRequest',
            'onEndRequest'=>'endRequest',
		));
	}

	/**
	 * Load configuration that cannot be put in config/main
	 */
	public function beginRequest()
	{
        if (isset($_POST['_lang']))
			$this->owner->user->setState('applicationLanguage', $_POST['_lang']);
		if ($this->owner->user->getState('applicationLanguage'))
			$this->owner->language=$this->owner->user->getState('applicationLanguage');
		else
			$this->owner->language='pt_br';
		
		if ( ($this->owner->language=='pt_br')&&(isset(Yii::app()->user->empresa))&&(Yii::app()->user->empresa=='valao') ) $this->owner->language='pt';
		//if ( (isset(Yii::app()->user->id))&&(ErpnetUser::model()->findByPk(Yii::app()->user->id)->trocar_senha) ) 
		//SiteController::redirect(array('/site/trocarSenha'));
		//Yii::app()->request->redirect(array('/site/trocarSenha'));
		//$this->owner->request->redirect(array('/site/trocarSenha'));


        if (file_exists ($_SERVER['DOCUMENT_ROOT'].'/protected/config/dyn.config.'.$_SERVER['HTTP_HOST'].'.inc.php'))
            require_once($_SERVER['DOCUMENT_ROOT'].'/protected/config/dyn.config.'.$_SERVER['HTTP_HOST'].'.inc.php');
	}

    public function endRequest() {
        return true;
    }
}
?>