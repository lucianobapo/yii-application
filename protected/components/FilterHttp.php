<?php
class FilterHttp extends CFilter
{
	protected function preFilter($filterChain)
	{
		if ( Yii::app()->getRequest()->isSecureConnection )
		{
			# Redirect to the secure version of the page.
			$url = 'http://' .
				Yii::app()->getRequest()->serverName .
				Yii::app()->getRequest()->requestUri;
			Yii::app()->request->redirect($url);
			return false;
		}
		return true;
	}
}