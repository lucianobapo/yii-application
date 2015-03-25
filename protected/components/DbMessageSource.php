<?php

class DbMessageSource extends CDbMessageSource
{
	private $_messages=array();
	
	public function onMissingTranslation($event){
		parent::onMissingTranslation($event);
		Yii::trace('Error on translation: '.$event->category.' - '.$event->language.' - '.$event->message,'application.translation');
		//Helpers::gravaArquivoErro($event->category.' - '.$event->language.' - '.$event->message);
	}
	protected function translateMessage($category,$message,$language){
		$key=$language.'.'.$category;
		if(!isset($this->_messages[$key]))
			$this->_messages[$key]=$this->loadMessages($category,$language);
		if(isset($this->_messages[$key][$message]) && $this->_messages[$key][$message]!=='')
			return ($this->_messages[$key][$message]);
		elseif(!$this->hasEventHandler('onMissingTranslation'))
		{
			$event=new CMissingTranslationEvent($this,$category,$message,$language);
			$this->onMissingTranslation($event);
			return $event->message;
		}
		else
			return $message;
	}
}