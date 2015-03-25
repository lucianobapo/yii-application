<?php

class HomeController extends Controller
{
	//public $layout='//layouts/column3';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	public function actionIndex()
	{
		if (Helpers::getModuleName()=='delivery') $this->layout='//layouts/column3';
		$this->setPageTitle(Helpers::t('appTitles',ucfirst($this->id),array(),'i18n',null,false));

		if ( (!Yii::app()->user->isGuest)
			&& ($this->getViewFile('application.modules.'.Helpers::getModuleName().'.views.default.'.Yii::app()->user->empresa)))
			$this->render('application.modules.'.Helpers::getModuleName().'.views.default.'.Yii::app()->user->empresa);
		else
			$this->render('application.modules.'.Helpers::getModuleName().'.views.default.home', array());
		//echo Yii::app()->controller->id;
		//echo Yii::app ()->controller->action->id;
		//echo $this->getViewPath();
		//echo '<pre>'.CVarDumper::dumpAsString($this->getViewFile('application.modules.delivery.views.default.home')).'</pre>';
		//echo $this->getViewFile('home');
		//echo '<pre>'.CVarDumper::dumpAsString($this->resolveViewFile('home','delivery/default','/')).'</pre>';
		//echo '<pre>'.CVarDumper::dumpAsString(YiiBase::getPathOfAlias('application.modules.delivery.views.default')).'</pre>';
	}



}