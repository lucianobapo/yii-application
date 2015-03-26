<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		if ((!Yii::app()->user->isGuest) && ($this->getViewFile(Yii::app()->user->empresa))) $this->render(Yii::app()->user->empresa);
		else $this->render('home');
		
	}
}