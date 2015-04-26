<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.


$config_gen = array(
	//'language' => 'pt_br',
	//'language' => 'en',
	//'charset' => 'utf8_unicode_ci',
	//'charset' => 'iso-8859-1',
	'timeZone' =>'America/Sao_Paulo',
	//'caseSensitive' => true,
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	//'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR,
	//'name'=>'WEB ComEx',
	//'theme'=>'designa',
	//'theme'=>'neutraldesk',
	//'theme'=>'redruby',
	//'theme'=>'blackboot',
	

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.quickdlgs.*',
		//'ext.pagseguro.*',
			
		//'ext.components.database.*',
		//'ext.widgets.portlet.XPortlet',
		//'ext.helpers.XHtml',
		//'ext.modules.help.models.*',
		//'ext.modules.lookup.models.*',
		//'ext.fpdf.*',
		//'ext.superfish.*',
	),
	'behaviors' => array('ApplicationConfigBehavior'),

	
	// application components
	'components'=>array(

		'menu'=>array(
			'class'=>'HelpersDynamic'
		),

		'buscaPorCep'=>array(
			'class'=>'ext.correios.BuscaPorCepApp'
		),

		'Smtpmail'=>array(
			'class'=>'application.extensions.smtpmail.PHPMailer',
			'Host'=>getenv("SMTP_HOST"),
			'Username'=>getenv("SMTP_USER"),
			'Password'=>getenv("SMTP_PASS"),
			'Mailer'=>'smtp',
			'Port'=>getenv("SMTP_PORT"),
			'SMTPAuth'=>true,
			'SMTPSecure'=>'ssl',
//			'SMTPSecure'=>'tls',
		),
		//*
		'ePdf' => array(
			'class'         => 'ext.yii-pdf.EYiiPdf',
			
			'params'        => array(
				'mpdf'     => array(
					'librarySourcePath' => 'application.vendors.mpdf.*',
					'constants'         => array(
							'_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
					),
					'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
				),
				'HTML2PDF' => array(
					'librarySourcePath' => 'ext.yii-pdf.*',
					//'librarySourcePath' => 'ext.yii-pdf.*',
					'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
					
					'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
						'orientation' => 'P', // landscape or portrait orientation
						'format'      => 'A4', // format A4, A5, ...
						'language'    => 'en', // language: fr, en, it ...
						'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
						'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
						'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
					)
				),
			),
		),
		//*/
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/site/execLogin'),
		),
		// uncomment the following to enable URLs in path-format
		//*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'showScriptName'=>false,
			'urlSuffix'=>'.html',
		),
		//*/

		//*
		'db'=>array(
				'class'=>'CDbConnection',
				'connectionString'=>'mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DB"),
				'username' => getenv("MYSQL_USER"),
				'password' => getenv("MYSQL_PASS"),
				//'schemaCachingDuration'=>60*300,
				//'queryCachingDuration'=>60*5,
				//'queryCachingCount'=>500,
				//'queryCachingDependency'=> new CDbCacheDependency('SELECT MAX(updated_at) FROM erpnet_ordem'),
				//'caseSensitive' => true,
				'charset' => 'utf8',
				'enableProfiling'=>true,
				'enableParamLogging' => true,
		),
		'authManager'=>array(
				'class'=>'CDbAuthManager',
				'connectionID'=>'db',
		),
		//*/
		
		
		'i18n' => array(
				'class' => 'DbMessageSource',
				'connectionID' => 'db',
				'forceTranslation' => true,
				'cachingDuration'=>(60*30),
				'cacheID'=>'cache',
		),
		//'cache'=>array(
				//'class'=>'system.caching.CDbCache',
		//),
		
		'cache'=>array(
				'class'=>'CMemCache',
				'servers'=>array(
						array('host'=>getenv("MEMCACHE_HOST"), 'port'=>11211, 'weight'=>60),
						//array('host'=>'server2', 'port'=>11211, 'weight'=>40),
				),
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				/*
				array(
					'class'=>'CFileLogRoute',
					//'levels'=>'trace, info, error, warning',
					//'levels'=>'trace, error, warning',
					//'levels'=>'error',
					'levels'=>'error, warning',
				),

				array(
					'enabled'=>true,
					'class'=>'EmailLogRoute',
					'levels'=>'trace, error, warning',
					'categories'=>'application.delivery',
					'emails'=>'ilhanet.lan@gmail.com',
					'utf8'=>true,
				),

				array(
						'class'=>'CProfileLogRoute',
						'report'=>'summary',
					'levels'=>'error, warning, trace, info, profile',
				),
				//*/
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'error, warning, trace, info, profile',
					'showInFireBug'=>true,
				),
				//*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'site'=>'<a href="http://ilhanet.com" target="_blank">ilhanet.com</a>',
		'metaAutor'=>'Luciano Porto - ilhanet.com',
		'metaDescription'=>'Delivery Entrega em Rio das Ostras, Aberto 24 horas, Frete Grátis, Bebidas, Petiscos, Cerveja Gelada, Vodka, Energético, Sucos, Refrigerante Gelado, Gelo em escama. Faça seu pedido pelo SITE.',
		// this is used in contact page
		'adminEmail'=>'ilhanet.lan@gmail.com',
		'adminEmail2'=>'luciano.bapo@gmail.com',
		'adminEmailLink'=>'<a href="mailto:ilhanet.lan@gmail.com" target="_top">ilhanet.lan@gmail.com</a>',
		'company'=>'IlhaNET',
		'companyLink'=>'<a href="http://ilhanet.com" target="_blank">IlhaNET</a>',
		'traducao'=>false,
		'GoogleAnalytics'=>false,
		'GoogleAnalyticsCode'=>"",
		// this is where feedback is sent
		'contactEmail' => 'ilhanet.lan@gmail.com',
		// this is used in error pages
		//'adminEmail' => 'your.name@domain.com',
		//pagesizes
		'pageSize' => 10,
		// google
		//'googleAnalytics' => false,
		//'googleAnalyticsTracker' => '',
		//'googleApiKey' => '',
		//upload directory
		'uploadDir' => 'upload2/',
		'moedas'=>array(
			'BRL'=>('BRL (R$)'),
			'USD'=>('USD (US$)'),
			'EUR'=>('EUR (€)'),
		),
		'unidades'=>array(
			'UN'=>('UN - Unidade'),
			'm3'=>('m³ - Metro Cúbico'),
			'm'=>('m - Metro'),
			'mm'=>('mm - Milímetro'),
			'l'=>('l - Litro'),
			'ml'=>('ml - Mililitro'),
			'CX'=>('CX - Caixa'),
			'Kg'=>('Kg - Kilograma'),
		),
		'pagamento'=>array(
				'vistad'=>('A Vista - Dinheiro'),
				'fiado'=>('Venda Fiado'),
				'vistacc'=>('A Vista - Cartão Crédito'),
				'vistacd'=>('A Vista - Cartão Débito'),
				'1parcelado'=>('A Prazo 1x'),
				'2parcelado'=>('A Prazo 2x'),
				'3parcelado'=>('A Prazo 3x'),
		),
	),
);



if (($_SERVER['HTTP_HOST']=='webcomex.ilhanet.com')||($_SERVER['HTTP_HOST']=='webcomex.localhost.com') ) {
	$config_gen['theme']='webcomex';
	$config_gen['name']='WEB ComEx';
	//$config_gen['endereco']='erpnet.ilhanet.com';
	$config_gen['modules']=array(

		//'i18n',
		//'report',
		'webcomex',
			
	);
	//array_push($config_gen['params'],array('traducao'=>false));
}

elseif (($_SERVER['HTTP_HOST']=='ndtreport.ilhanet.com')||($_SERVER['HTTP_HOST']=='ndtreport.localhost.com') ) {
	$config_gen['theme']='ndtreport';
	//$config_gen['endereco']='erpnet.ilhanet.com';
	$config_gen['name']='NDT Report';
	$config_gen['modules']=array(

		//'i18n',
		'ndtreport',
		//'comex',
	);
	//$config_gen['params']
	//array_push($config_gen['params'],array('traducao'=>true));
	$config_gen['params']['traducao']=true;
	
}

elseif (($_SERVER['HTTP_HOST']=='www.ilhanet.com')||($_SERVER['HTTP_HOST']=='ilhanet.com')||($_SERVER['HTTP_HOST']=='localhost.com') ) {
	$config_gen['theme']='ilhanet';
	//$config_gen['theme']='ndtreport';
	//$config_gen['endereco']='erpnet.ilhanet.com';
	$config_gen['name']='IlhaNET';
	$config_gen['modules']=array(
			//'i18n',
			//'report',
			//'comex',
	);
	//array_push($config_gen['params'],array('traducao'=>false));
}

//Configuração personalizada do host
if (file_exists ($_SERVER['DOCUMENT_ROOT'].'/protected/config/'.$_SERVER['HTTP_HOST'].'.inc.php'))
	require_once($_SERVER['DOCUMENT_ROOT'].'/protected/config/'.$_SERVER['HTTP_HOST'].'.inc.php');
else die('erro no arquivo: '.$_SERVER['DOCUMENT_ROOT'].'/protected/config/'.$_SERVER['HTTP_HOST'].'.inc.php');

//array_push($config,array('theme'=>'redruby'));

//var_dump($config_gen);
return $config_gen;
