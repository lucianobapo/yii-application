<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		Yii::beginProfile(get_class($this));
		if ((!Yii::app()->user->isGuest) && ($this->getViewFile(Yii::app()->user->empresa))) $this->render(Yii::app()->user->empresa);
		else {
			//$home = new HomeController('HomeController');
			//$home->actionIndex();
			$this->render('home');
		}
		Yii::endProfile(get_class($this));
	}
}
