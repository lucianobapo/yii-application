<?php
//Configuração Remota delivery.ilhanet.com.inc.php

//error_reporting(E_ALL);
//error_reporting(E_ALL|E_STRICT|E_NOTICE);
//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE|E_WARNING));
//error_reporting(E_ALL & ~(E_NOTICE));
error_reporting(E_ALL & ~(E_NOTICE|E_WARNING));

//$config_gen['theme']='erpnet';
$config_gen['theme']='delivery';
$config_gen['name']='Delivery 24hs';
$config_gen['components']['user']['loginUrl']='/';


/*
 *	Configuração do login social
 */

$config_gen['components']['hybridAuth']=array(
	'class'=>'ext.widgets.hybridAuth.CHybridAuth',
	'enabled'=>true, // enable or disable this component
	'config'=>array(
		"base_url" => 'https://'.$_SERVER ['HTTP_HOST'].'/site/endpoint',
		"providers" => array(
			"Google" => array(
				"enabled" => true,
				"keys" => array(
					"id" => getenv("SOCIAL_GOOGLE_ID"),
					"secret" => getenv("SOCIAL_GOOGLE_SECRET")),
			),
			"Facebook" => array(
				"enabled" => true,
				"keys" => array(
                    "id" => getenv("SOCIAL_FACEBOOK_ID"),
                    "secret" => getenv("SOCIAL_FACEBOOK_SECRET")),
				"scope"   => "email, user_birthday",
				"display" => "popup",
			),
			"Twitter" => array(
				"enabled" => false,
				"keys" => array("key" => "", "secret" => "")
			),
			"Live" => array(
				"enabled" => true,
				"keys" => array("id" => getenv("SOCIAL_LIVE_ID"), "secret" => getenv("SOCIAL_LIVE_SECRET")),
			),
		),
		"debug_mode" => YII_DEBUG,
		"debug_file" => $_SERVER['DOCUMENT_ROOT'].'/protected/runtime/hybrid_logs.txt',
	),
);



/*
 *	Configuração dos Logs
 */

//config log em arquivo
$config_gen['components']['log']['routes'][]=array(
	'enabled'=>YII_DEBUG,
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
array_push($config_gen['components']['log']['routes'],array(
    //'enabled'=>YII_DEBUG,
    'enabled'=>YII_DEBUG,
    'class'=>'CWebLogRoute',
    //'levels'=>'error, warning, trace, info, profile',
    'levels'=>'trace',
    'categories'=>'application.delivery*',
));
/*
$config_gen['components']['log']['routes'][]=array(
	//'enabled'=>YII_DEBUG,
	'enabled'=>true,
	'class'=>'CWebLogRoute',
	//'levels'=>'error, warning, trace, info, profile',
    'levels'=>'trace',
    //'categories'=>'application.delivery*',
	//'categories'=>'system.db.ar',
    //'except'=>'system.db*',
	//'categories'=>'teste*',
	//'categories'=>'DbAccess.*',
	//'except'=>'DbAccess.getErpnetProdutos',
	//'except'=>'application.translation, system.CModule, system.caching.*, system.web.auth.CDbAuthManager, system.db.CDbCommand.*',
	//'showInFireBug'=>true,
);
*/
//config log profile na página da web
$config_gen['components']['log']['routes'][]=array(
	//'enabled'=>YII_DEBUG,
    //'enabled'=>true,
    'enabled'=>YII_DEBUG,
	'class'=>'CProfileLogRoute',
	'report'=>'summary',
	//'levels'=>'error, warning, trace, info, profile',
    'levels'=>'trace',
);

//config log toolbar
$config_gen['components']['log']['routes'][]=array(
    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
    //'ipFilters'=>array('*'),
);


/*
 *	Configuração da tradução do site
 */

//config componente i18n
$config_gen['components']['i18n']=array(
	'class' => 'DbMessageSource',
	'connectionID' => 'db',
	'forceTranslation' => true,
	'cachingDuration'=>(60*60),
	'cacheID'=>'cache',
);



/*
 *	Configuração dos Módulos
 */

$config_gen['modules']=array(

	'delivery',
	'erpnet',
	//'comex',
	/*
    'payPal'=>array(
        'env'=>'sandbox',
        'account'=>array(
            'username'=>getenv("PAYPAL_USER"),
            'password'=>getenv("PAYPAL_PASS"),
            'signature'=>getenv("PAYPAL_SIGNATURE"),
            'email'=>'luciano.bapo@gmail.com',
            'identityToken'=>'Your PayPal identity token',
        ),
        'components'=>array(
            'buttonManager'=>array(
                //'class'=>'payPal.components.PPDbButtonManager'
                'class'=>'payPal.components.PPPhpButtonManager',
            ),
        ),
    ),
    //*/
);



/*
 *	Configuração dos Parâmetros personalizados
 */

$config_gen['params']['zeraSaldo']=false;
$config_gen['params']['fechado']=false;
$config_gen['params']['metaRobots']='index, follow';
$config_gen['params']['traducao']=true;
$config_gen['params']['pagseguro']=false;
$config_gen['params']['appSite']='<a href="http://delivery.ilhanet.com" target="_blank">delivery.ilhanet.com</a>';
$config_gen['params']['appSiteURL']='http://delivery.ilhanet.com';
$config_gen['params']['appSiteLogo']='http://delivery.ilhanet.com/images/logo.png';
$config_gen['params']['endereco']='Rua Laércio Lúcio de Carvalho, Centro';
$config_gen['params']['endereco2']='Rio das Ostras/RJ - CEP 28893-818';
$config_gen['params']['grupoDelivery']=(strpos ( $_SERVER ['HTTP_HOST'], 'localhost.com' )? 21:22);

$config_gen['params']['queryCache']=array(
	'DbAccess'=>array(
		'cachingDuration'=>60*60, // sessenta minutos
		'cacheID'=>'cache',

	),
);

$config_gen['params']['boxSocial']=true;

// Minificar arquivos
$config_gen['params']['minifyHTML']=true;
$config_gen['params']['minifyCSS']=true;
$config_gen['params']['minifyJS']=true;

// Pagamentos aceitos
$config_gen['params']['cartaoDebito']=true;
$config_gen['params']['cartaoCredito']=true;

// Google Analytics
$config_gen['params']['GoogleAnalytics']=true;
$config_gen['params']['GoogleAnalyticsCode']="(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', '".getenv("GOOGLE_ANALYTICS_ID")."', 'auto');
	ga('require', 'linkid', 'linkid.js');
	ga('require', 'displayfeatures');
  	ga('send', 'pageview');";
$config_gen['params']['FacebookAnalyticsCode']="<!-- Facebook Conversion Code for Visualizações da página principal - Delivery Rio Das Ostras 1 -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6028312549771', {'value':'0.00','currency':'BRL'}]);
</script>
<noscript><img height=1 width=1 alt='' style='display:none'
src='https://www.facebook.com/tr?ev=6028312549771&amp;cd[value]=0.00&amp;cd[currency]=BRL&amp;noscript=1' /></noscript>";