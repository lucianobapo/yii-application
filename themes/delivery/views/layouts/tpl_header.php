<!DOCTYPE html>
<html lang="pt-br" ng-app="delivery" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="'http://ogp.me/ns#">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo Yii::app()->params['metaDescription'];?>">
    <meta name="robots" content="<?php echo Yii::app()->params['metaRobots'];?>">
    <meta name="author" content="<?php echo Yii::app()->params['metaAutor'];?>">

    <meta property='og:title' content='<?php echo CHtml::encode($this->pageTitle); ?>' />
    <meta property='og:description' content='<?php echo Yii::app()->params['metaDescription'];?>' />
    <meta property='og:url' content='<?php echo Yii::app()->params['appSiteURL'];?>' />
    <meta property='og:image' content='<?php echo Yii::app()->params['appSiteLogo'];?>'/>
    <meta property='og:type' content='website' />
    <meta property='og:site_name' content='<?php echo Yii::app()->name;?>' />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@DeliveryLan" />
    <meta name="twitter:title" content="<?php echo CHtml::encode($this->pageTitle); ?>" />
    <meta name="twitter:description" content="<?php echo Yii::app()->params['metaDescription'];?>" />
    <meta name="twitter:image" content="<?php echo Yii::app()->params['appSiteLogo'];?>" />
    <meta name="twitter:url" content="<?php echo Yii::app()->params['appSiteURL'];?>" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    //$cs->registerCoreScript('jquery');
    //$cs->registerScriptFile($baseUrl.'/js/angular.min.js');
    //$cs->registerScriptFile($baseUrl.'/js/ui-utils.js');

    $cs->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js',CClientScript::POS_BEGIN);
    $cs->registerScriptFile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js",CClientScript::POS_BEGIN);
    $cs->registerScriptFile("https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js",CClientScript::POS_BEGIN);
    //$cs->registerScriptFile("/js/less-2.3.1.min.js",CClientScript::POS_BEGIN);

    //$cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/tooltipster/3.0.5/js/jquery.tooltipster.min.js',CClientScript::POS_END);

    //$cs->registerScriptFile($baseUrl.'/js/angular-locale_pt-br.min.js',CClientScript::POS_END);
    //$cs->registerScriptFile($baseUrl.'/js/jquery.tooltipster.min.js',CClientScript::POS_END);
    //$cs->registerScriptFile($baseUrl.'/js/jquery.price_format.2.0.min.js',CClientScript::POS_END);
    //$cs->registerScriptFile($baseUrl.'/js/valida_cpf_cnpj.min.js',CClientScript::POS_END);
    //$cs->registerScriptFile($baseUrl.'/js/exemplo_1.min.js',CClientScript::POS_END);

    //$cs->registerCssFile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css");
    //$cs->registerCssFile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css");
    //$cs->registerCssFile("https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
    //$cs->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/4.2.1/bootstrap-social.min.css");
    //$cs->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/tooltipster/3.0.5/css/tooltipster.min.css");


    /*
    $css='';
    $arquivo = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css';
    $css = $css.file_get_contents($arquivo);
    $arquivo = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css';
    $css = $css.file_get_contents($arquivo);
    $arquivo = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css';
    $css = $css.file_get_contents($arquivo);
    ($css!='')? $cs->registerCss(rand(),(Yii::app()->params['minifyCSS']? CssMin::minify($css):$css)):die('css branco');
    */

    $css='';


    $arquivo = $_SERVER['DOCUMENT_ROOT'].'/css/delivery.css';
    is_file($arquivo)? $css = $css.file_get_contents($arquivo):die($arquivo);

    //$arquivo = $_SERVER['DOCUMENT_ROOT'].'/css/bootstrap-social.min.css';
    //is_file($arquivo)? $css = $css.file_get_contents($arquivo):die($arquivo);

    //$arquivo = $_SERVER['DOCUMENT_ROOT'].'/css/tooltipster.min.css';
    //is_file($arquivo)? $css = $css.file_get_contents($arquivo):die($arquivo);

    $arquivo = $_SERVER['DOCUMENT_ROOT'].'/css/structure.'.$_SERVER['HTTP_HOST'].'.css';
    is_file($arquivo)? $css = $css.file_get_contents($arquivo):die($arquivo);

    $arquivo = $_SERVER['DOCUMENT_ROOT'].'/css/visual.'.$_SERVER['HTTP_HOST'].'.css';
    is_file($arquivo)? $css = $css.file_get_contents($arquivo):die($arquivo);



    ($css!='')? $cs->registerCss(rand(),(Yii::app()->params['minifyCSS']? CssMin::minify($css):$css)):die('css branco');


    //$arquivo=file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/jquery-1.7.1.min.js');
    //$cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify($arquivo):$arquivo),CClientScript::POS_BEGIN );
    //$arquivo=file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/angular.min.js');
    //$cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify($arquivo):$arquivo),CClientScript::POS_BEGIN );
    //$arquivo=file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/bootstrap332/js/bootstrap.min.js');
    //$cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify($arquivo):$arquivo),CClientScript::POS_BEGIN );

    //$arquivo=file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/jquery.tooltipster.min.js');
    //$cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify($arquivo):$arquivo),CClientScript::POS_BEGIN );
    $arquivo=file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/jquery.price_format.2.0.min.js');
    $cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify($arquivo):$arquivo),CClientScript::POS_BEGIN );

    if (Yii::app()->params['boxSocial']) {
        $arquivo='(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=1581785262035600&version=v2.0";  fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));';
        $cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify($arquivo):$arquivo),CClientScript::POS_BEGIN );
    }


    //$arquivo=($_SERVER['DOCUMENT_ROOT'].'/js/moment.js');
    //$cs->registerScriptFile($arquivo,CClientScript::POS_END );
    //$arquivo=($_SERVER['DOCUMENT_ROOT'].'/js/bootstrap-datetimepicker.js');
    //$cs->registerScriptFile($arquivo,CClientScript::POS_END );

    $arquivo=file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/angular-locale_pt-br.min.js');
    $cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify($arquivo):$arquivo),CClientScript::POS_END );
    $arquivo=file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/valida_cpf_cnpj.min.js');
    $cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify($arquivo):$arquivo),CClientScript::POS_END );
    $arquivo=file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/exemplo_1.min.js');
    $cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify($arquivo):$arquivo),CClientScript::POS_END );


    if (Yii::app()->params['GoogleAnalytics'])
        $cs->registerScript(rand(),(Yii::app()->params['minifyJS']? JSMin::minify(Yii::app()->params['GoogleAnalyticsCode']):Yii::app()->params['GoogleAnalyticsCode']),CClientScript::POS_END );

        //$cs->registerScript(rand(),file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/jquery.tooltipster.min.js'),CClientScript::POS_BEGIN );
        //$cs->registerScript(rand(),file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/jquery.price_format.2.0.min.js'),CClientScript::POS_BEGIN );

        //$cs->registerScript(rand(),file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/angular-locale_pt-br.min.js'),CClientScript::POS_END );
        //$cs->registerScript(rand(),file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/valida_cpf_cnpj.min.js'),CClientScript::POS_END );
        //$cs->registerScript(rand(),file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/js/exemplo_1.min.js'),CClientScript::POS_END );

    ?>
    <!--
        <link rel="stylesheet/less" type="text/css" href="/less/bootstrap.less" />
        <script type="text/javascript" src="/js/less-2.3.1.min.js"></script>
     -->
        <!-- The fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $baseUrl;?>/img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/img/ico/apple-touch-icon-57-precomposed.png">

</head>

<body class="vb21">
<?php echo Helpers::getFacebookLike('script'); ?>
<?php echo Helpers::getGoogleLike('script'); ?>
<header>
    <section class="vb26">
        <!-- Include the header bar -->
        <?php include_once('header.php');?>
        <!-- /.container -->
    </section><!-- /#header -->
</header>
