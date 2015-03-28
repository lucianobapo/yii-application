<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--     <meta name="description" content="Free yii themes, free web application theme">
    <meta name="author" content="Webapplicationthemes.com">
	<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>-->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php
	$baseUrl = Yii::app()->theme->baseUrl;
	$cs = Yii::app()->getClientScript();
    $cs->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js',CClientScript::POS_HEAD);

    //$cs->registerScriptFile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js",CClientScript::POS_BEGIN);
    $cs->registerScriptFile("https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js",CClientScript::POS_BEGIN);

    $cs->registerScriptFile("https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js",CClientScript::POS_HEAD);
    $cs->registerScriptFile("https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.min.js",CClientScript::POS_HEAD);
    $cs->registerScriptFile("https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.stack.min.js",CClientScript::POS_HEAD);


    //$cs->registerScriptFile("https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.pie.min.js",CClientScript::POS_END);
    //$cs->registerScriptFile("https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.categories.min.js",CClientScript::POS_END);

    //Yii::app()->clientScript->registerCoreScript('jquery');

	?>
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-57-precomposed.png">
	<?php  
	  $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
	  $cs->registerCssFile($baseUrl.'/css/abound.css');
	  $cs->registerCssFile($baseUrl.'/css/zocial.css');
      $cs->registerCssFile('/css/delivery.css');
	  //$cs->registerCssFile($baseUrl.'/css/style-blue.css');
	  ?>
      <!-- styles for style switcher -->
      	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/css/style-blue.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style2" href="<?php echo $baseUrl;?>/css/style-brown.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style3" href="<?php echo $baseUrl;?>/css/style-green.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style4" href="<?php echo $baseUrl;?>/css/style-grey.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style5" href="<?php echo $baseUrl;?>/css/style-orange.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style6" href="<?php echo $baseUrl;?>/css/style-purple.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style7" href="<?php echo $baseUrl;?>/css/style-red.css" />
	  <?php
	  $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.pie.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/charts.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.knob.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.masonry.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/styleswitcher.js');
	  //$cs->registerScriptFile($baseUrl.'/js/jquery.price_format.2.0.js');
	  //$cs->registerScriptFile($baseUrl.'/js/aplicacao.js');
	  //$cs->registerScriptFile($baseUrl.'/js/jquery.js');
	  //Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/jquery/jquery.price_format.1.7.min.js');
	?>
  </head>

<body>
<?php 
	if ((Helpers::isOnline())&&(Yii::app()->params['GoogleAnalytics'])) 
		echo Yii::app()->params['GoogleAnalyticsCode'];
?>
<section id="navigation-main">   
<!-- Require the navigation -->
<?php require_once('tpl_navigation.php')?>
</section><!-- /#navigation-main -->
    
<section class="main-body">
    <div class="container-fluid">
            <!-- Include content pages -->
            <?php echo $content; ?>
    </div>
</section>

<!-- Require the footer -->
<?php require_once('tpl_footer.php')?>

  </body>
</html>