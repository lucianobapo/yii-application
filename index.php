<?php
//die (var_dump($_SERVER));

/*
if (strpos ( $_SERVER ['HTTP_HOST'], 'localhost.com' )) {
    define('YII_DEBUG',true);
    //define('YII_DEBUG',false);

    // specify how many levels of call stack should be shown in each log message
    define('YII_TRACE_LEVEL',8);

	$config=dirname(__FILE__).'/protected/config/main.php';
	require_once (dirname(__FILE__).'/yii/framework/yii.php');
} else {
    //define('YII_DEBUG',true);
    define('YII_DEBUG',false);
    // specify how many levels of call stack should be shown in each log message
    define('YII_TRACE_LEVEL',3);

	//$yii='/var/yii/framework1115022a51/yii.php';
	$config=dirname(__FILE__).'/protected/config/main.php';
	//require_once ('/var/www/yii1116bca042/framework/yii.php');
    require_once ('/var/www/yii1115022a51/framework/yii.php');
}
*/
//Configuração personalizada do host
if (file_exists ($_SERVER['DOCUMENT_ROOT'].'/protected/config/index.config.'.$_SERVER['HTTP_HOST'].'.inc.php'))
    require_once($_SERVER['DOCUMENT_ROOT'].'/protected/config/index.config.'.$_SERVER['HTTP_HOST'].'.inc.php');
else
    die('erro no arquivo: '.$_SERVER['DOCUMENT_ROOT'].'/protected/config/index.config.'.$_SERVER['HTTP_HOST'].'.inc.php');


Yii::createWebApplication($config)->run();