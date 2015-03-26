<?php
//Configuração Remota erpnet.ilhanet.com.inc.php

//error_reporting(E_ALL);
//error_reporting(E_ALL|E_STRICT|E_NOTICE);
//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE|E_WARNING));
//error_reporting(E_ALL & ~(E_NOTICE));
error_reporting(E_ALL & ~(E_NOTICE|E_WARNING));

$config_gen['theme']='erpnet';
$config_gen['name']='ERPnet';
$config_gen['params']['traducao']=true;
//$config_gen['components']['user']['loginUrl']='/';

/*
 *	Configuração dos Logs
 */

//config log em arquivo
$config_gen['components']['log']['routes'][]=array(
	'enabled'=>false,
	'class'=>'CFileLogRoute',
	//'levels'=>'trace, info, error, warning',
	'levels'=>'trace, error, warning',
	//'levels'=>'error',
	//'levels'=>'error, warning',
);

//config log por email
//*
$config_gen['components']['log']['routes'][]=array(
	'enabled'=>false,
	'class'=>'EmailLogRoute',
	//'levels'=>'trace, error, warning',
	'levels'=>'error, warning',
	//'categories'=>'application.delivery',
	'emails'=>$config_gen['params']['contactEmail'],
	'utf8'=>true,
);//*/

//config log na página da web
$config_gen['components']['log']['routes'][]=array(
	'enabled'=>YII_DEBUG,
	//'enabled'=>false,
	'class'=>'CWebLogRoute',
	'levels'=>'error, warning, trace, info, profile',
	//'categories'=>'system.db.ar',
	'categories'=>'teste*',
	//'categories'=>'DbAccess.*',
	//'except'=>'DbAccess.getErpnetProdutos',
	//'except'=>'application.translation, system.CModule, system.caching.*, system.web.auth.CDbAuthManager, system.db.CDbCommand.*',
	//'showInFireBug'=>true,
);

//config log profile na página da web
$config_gen['components']['log']['routes'][]=array(
	'enabled'=>YII_DEBUG,
	'class'=>'CProfileLogRoute',
	'report'=>'summary',
	'levels'=>'error, warning, trace, info, profile',
);


/*
 *	Configuração da tradução do site
 */

//config componente i18n
$config_gen['components']['i18n']=array(
	'class' => 'DbMessageSource',
	'connectionID' => 'db',
	'forceTranslation' => true,
	'cachingDuration'=>0,
	'cacheID'=>'cache',
);

/*
 *	Configuração dos Módulos
 */

$config_gen['modules']=array(
	'erpnet',


);


/*
 *	Configuração dos Parâmetros personalizados
 */

$config_gen['params']['zeraSaldo']=false;
$config_gen['params']['metaRobots']='index, follow';
$config_gen['params']['traducao']=true;
$config_gen['params']['pagseguro']=false;
$config_gen['params']['appSite']='<a href="http://erpnet.ilhanet.com" target="_blank">erpnet.ilhanet.com</a>';
$config_gen['params']['appSiteURL']='http://erpnet.ilhanet.com';
$config_gen['params']['appSiteLogo']='http://erpnet.ilhanet.com/images/logo.png';
$config_gen['params']['endereco']='Rua Laércio Lúcio de Carvalho, Centro';
$config_gen['params']['endereco2']='Rio das Ostras/RJ - CEP 28893-818';
$config_gen['params']['grupoDelivery']=(strpos ( $_SERVER ['HTTP_HOST'], 'ilhanet.com' )? 22:22);

$config_gen['params']['queryCache']=array(
	'DbAccess'=>array(
		'cachingDuration'=>0, // sessenta minutos
		'cacheID'=>'cache',

	),
);

$config_gen['params']['boxSocial']=false;
$config_gen['params']['minifyHTML']=false;
$config_gen['params']['minifyCSS']=false;
$config_gen['params']['minifyJS']=false;

// Google Analytics
$config_gen['params']['GoogleAnalytics']=false;
$config_gen['params']['GoogleAnalyticsCode']="";


/*
 *	Configuração dos Componentes
 */


/*
 *	Configuração do login social
 */

$config_gen['components']['hybridAuth']=array(
	'class'=>'ext.widgets.hybridAuth.CHybridAuth',
	'enabled'=>false, // enable or disable this component
	'config'=>array(
	),
);