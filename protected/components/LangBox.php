<?php
class LangBox extends CWidget
{
	public $mostra=true;
	public function run()
	{
		$currentLang = Yii::app()->language;
		$linguagens=array(
				'en_us' => 'English',
				'pt_br' => utf8_encode('Portugu�s'));
		if (isset(Yii::app()->user->empresa)) {
			if (Yii::app()->user->empresa=='valao') $linguagens['pt']=Helpers::t('appUi','Português (Valão)');
            $config = ErpnetConfig::model()->findByPk(Yii::app()->user->empresa);
			$this->mostra=(is_object($config)?$config->mostra_lang:false);
		}
		
		if ($this->mostra) 
			$this->render('langBox', array('currentLang' => $currentLang,'linguagens'=>$linguagens));
	}
}
