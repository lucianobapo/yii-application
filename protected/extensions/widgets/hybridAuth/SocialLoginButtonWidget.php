<?php
class SocialLoginButtonWidget extends CWidget {
    
    public $type='button'; // options: button or icon
    public $buttonText='Signin with {provider}'; //
    public $htmlOptions=array(); // widget htmlOptions
    public $buttonHtmlOptions=array();  // individual button htmlOptions
    public $route; // route for processing hybrid auth
    public $params; // array of parameters (name=>value) that should be used instead of GET when generating button URL.
    public $paramVar='provider'; // name of the GET variable
    public $providers=array(); // array of providers
    public $enabled=true;
    public $delimiter='';
    
    private $_assetsUrl;
    
    /**
     * Initializes the widgets
     */
    public function init() {
        parent::init();
        
        if($this->_assetsUrl===null){
            $assetsDir=dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
            $this->_assetsUrl=Yii::app()->assetManager->publish($assetsDir);
        }
    }

    /**
     * Execute the widgets
     */
    public function run() {
    	//die('<pre>'.CVarDumper::dumpAsString($this->providers).'</pre>');
    	
    	if(!Yii::app()->user->isGuest || !$this->enabled) return ;
        
        Yii::beginProfile(get_class($this));
        
        //Yii::app()->clientScript->registerCssFile($this->_assetsUrl.'/css/zocial.css');
        
        if(!isset($this->htmlOptions['class']))
            $this->htmlOptions['class']='sb27';
        
        echo CHtml::openTag('div', $this->htmlOptions);
            foreach($this->providers as $provider){ 
            	$classe=array(
                    //'zocial',
                    'sb26 btn btn-social btn-xs',

                    //strtolower($provider),
                    //((strtolower($provider)=='live') ? 'btn-microsoft' : ((strtolower($provider)=='google') ? 'btn-google-plus' :strtolower($provider))),
                    //$this->type,
                );
                if (strtolower($provider)=='live') {
                    $classe[]='btn-microsoft';
                    $fa='fa-windows';
                }
                if (strtolower($provider)=='google') {
                    $classe[]='btn-google-plus';
                    $fa='fa-google-plus';
                }
                if (strtolower($provider)=='facebook') {
                    $classe[]='btn-facebook';
                    $fa='fa-facebook';
                }
                if (strtolower($provider)=='twitter') {
                    $classe[]='btn-twitter';
                    $fa='fa-twitter';
                }

                $this->buttonHtmlOptions['class']= implode(' ',$classe);
                $this->params[$this->paramVar]=$provider;
                echo CHtml::link(
                        '<i class="sb34 fa '.$fa.'"></i>'.
                        Yii::t('app',$this->buttonText, array('{provider}'=>$provider)),
                        Yii::app()->createAbsoluteUrl($this->route, $this->params,'https'),
                        $this->buttonHtmlOptions
                     ).$this->delimiter;
            }
        echo CHtml::closeTag('div');

        Yii::endProfile(get_class($this));
    }

}//end class