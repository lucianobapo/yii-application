<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52844003-1', 'auto');
  ga('send', 'pageview');

</script>

<?php if ((isset($HTTP_HOST))&&($HTTP_HOST!='localhost')) $this->widget('ext.widgets.googleAnalytics.EGoogleAnalyticsWidget',array('account'=>'UA-52844003-1','domainName'=>'ilhanet.com'));?>
<?php //echo Yii::app()->getLanguage(); 
/*
Yii::import('ext.yii-mail.YiiMailMessage');
$message = new YiiMailMessage;
$message->setBody('Message content here with HTML', 'text/html');
$message->subject = 'My Subject';
$message->addTo('luciano.bapo@gmail.com');
$message->from = Yii::app()->params['adminEmail'];
//Yii::app()->mail->send($message);
*/
?>
<div class="container" id="page">

	<div id="header">
		<div id="logo"><table id="lang"><tr><td><?php echo CHtml::encode( Yii::app()->name ); ?></td><td id="lang2"><?php echo Yii::t('app', 'appLang', array(), 'i18n'); $lang=new LangBox(); $lang->run(); ?></td></tr></table></div>
	</div><!-- header -->
	
	<div id="mainmenu">
		<?php Controller::getMenu(); ?>
	</div><!-- mainmenu -->
	<p>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::encode( Yii::app()->params['company'] ); ?>.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
