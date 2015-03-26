<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// widget action renders "static" pages stored under 'protected/views/site/widgets'
			// They can be accessed via: index.php?r=site/widget&view=FileName
			'widget'=>array(
				'class'=>'CViewAction',
				'basePath'=>'widgets',
			),
			'extension'=>array(
				'class'=>'CViewAction',
				'basePath'=>'extensions',
			),
			'module'=>array(
				'class'=>'CViewAction',
				'basePath'=>'modules',
			),
			'design'=>array(
				'class'=>'CViewAction',
				'basePath'=>'designs',
			),
			// ajaxContent action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/ajaxContent&view=FileName
			'ajaxContent'=>array(
				'class'=>'ext.actions.XAjaxViewAction',
			),
		);
	}

	/**
	 * @param CAction $action
	 * @return bool
     */
    protected function beforeAction($action)
	{
        if(parent::beforeAction($action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			$this->setPageTitle(Helpers::t('appTitles',ucfirst($this->getId()).ucfirst($action->getId()),array(),'i18n',null,false));
			return true;
		}
		else
			return false;
	}

	/**
	 * @return string
     */
	public function getModuleName() {
		return Helpers::getModuleName();
	}

}
	
	
