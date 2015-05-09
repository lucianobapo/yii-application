<?php
/* @var $this SiteController */

//$this->pageTitle=Yii::app()->name;
//$success = Yii::app()->s3->upload( $_SERVER['DOCUMENT_ROOT'].'/protected/data/'.date('Ymd').'.sql' , date('Ymd').'.sql', 'delivery-imagens' );
//Yii::app()->getComponents()
//echo '<pre>'.CVarDumper::dumpAsString(Yii::app()->getComponents()).'</pre>';

//Helpers::cloudFront();

/*

if (!class_exists('S3')) require_once 'S3.php';

// AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', '');
if (!defined('awsSecretKey')) define('awsSecretKey', '');


// Check for CURL
if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
	exit("\nERROR: CURL extension not loaded\n\n");

// Pointless without your keys!
if (awsAccessKey == 'change-this' || awsSecretKey == 'change-this')
	exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n".
		"define('awsAccessKey', 'change-me');\ndefine('awsSecretKey', 'change-me');\n\n");


S3::setAuth(awsAccessKey, awsSecretKey);


function test_createDistribution($bucket, $cnames = array()) {
	if (($dist = S3::createDistribution($bucket, true, $cnames, 'New distribution created')) !== false) {
		echo "createDistribution($bucket): "; var_dump($dist);
	} else {
		echo "createDistribution($bucket): Failed to create distribution\n";
	}
}

function test_listDistributions() {
	if (($dists = S3::listDistributions()) !== false) {
		if (sizeof($dists) == 0) echo "listDistributions(): No distributions\n";
		foreach ($dists as $dist) {
			var_dump($dist);
		}
	} else {
		echo "listDistributions(): Failed to get distribution list\n";
	}
}

function test_updateDistribution($distributionId, $enabled = false, $cnames = array()) {
	// To enable/disable a distribution configuration:
	if (($dist = S3::getDistribution($distributionId)) !== false) {
		$dist['enabled'] = $enabled;
		$dist['comment'] = $enabled ? 'Enabled' : 'Disabled';
		if (!isset($dist['cnames'])) $dist['cnames'] = array();
		foreach ($cnames as $cname) $dist['cnames'][$cname] = $cname;

		echo "updateDistribution($distributionId): "; var_dump(S3::updateDistribution($dist));
	} else {
		echo "getDistribution($distributionId): Failed to get distribution information for update\n";
	}
}

function test_deleteDistribution($distributionId) {
	// To delete a distribution configuration you must first set enable=false with
	// the updateDistrubution() method and wait for status=Deployed:
	if (($dist = S3::getDistribution($distributionId)) !== false) {
		if ($dist['status'] == 'Deployed') {
			echo "deleteDistribution($distributionId): "; var_dump(S3::deleteDistribution($dist));
		} else {
			echo "deleteDistribution($distributionId): Distribution not ready for deletion (status is not 'Deployed')\n";
			var_dump($dist);
		}
	}
}


//test_createDistribution($bucketName, array('my-optional-cname-alias.com'));
//test_listDistributions();
// "E4S5USZY109S8" is the distribution ID:
//test_updateDistribution('E4S5USZY109S8', false);
//test_deleteDistribution('E4S5USZY109S8');

*/

?>

<?php $this->renderPartial('application.modules.delivery.views.default.angularDeliveryHome', array()); ?>

	<article>

        <?php if(Yii::app()->params['fechado']): ?>
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo Helpers::t('appUi', 'Pedidos suspensos para manutenção de estoque. Retornaremos novamente dia 11/05/2015 às 09:00'); ?>
            </div>
        <?php endif; ?>

		<?php if(Yii::app()->user->hasFlash('erro')): ?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<?php echo Yii::app()->user->getFlash('erro'); ?>
			</div>
		<?php endif; ?>

		<?php if(Yii::app()->user->hasFlash('success')): ?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		<?php endif; ?>

		<?php if(Yii::app()->user->hasFlash('alert')): ?>
			<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo Yii::app()->user->getFlash('alert'); ?>
			</div>
		<?php endif; ?>

		<!-- <carrinho></carrinho> -->
	</article>

	<article>
		<?php
		//echo '<pre>'.CVarDumper::dumpAsString(Yii::app()->menu).'</pre>';
		if(Yii::app()->user->isGuest): ?>
			<em class="sb27"><?php echo Helpers::t('appUi','Entre pelas redes sociais e complete seu cadastro para fazer os pedidos'); ?></em>
			<?php
			$this->widget('ext.widgets.hybridAuth.SocialLoginButtonWidget', array(
				'enabled'=>Yii::app()->hybridAuth->enabled,
				'providers'=>Yii::app()->hybridAuth->getAllowedProviders(),
				'route'=>'site/authenticate',
				'buttonText'=>'Entrar com {provider}',
				//'buttonHtmlOptions'=>array('style'=>'font-size: 12px'),
				//'htmlOptions'=>array('class'=>'span3'),
				//'type'=>'icon',
				//'delimiter'=>' ',
			)); ?>
			<!-- Divisão de blocos -->
			</article></div></div><div class="container-delivery"><div><article>
		<?php endif; ?>

			<h1 class="st1 vt1"><?php echo Helpers::t('appUi','{empresa} - Frete Grátis, veja nossos produtos',array('{empresa}'=>Yii::app()->name)); ?></h1>
		<div class="sb16">
			<product-panels>
				<?php $this->renderPartial('application.modules.'.Helpers::getModuleName().'.views.default.product-panel'); ?>
			</product-panels>
		</div>
		<strong class="sb16"><?php echo Helpers::t('appUi', 'Atendemos a região de Rio das Ostras/RJ.');?></strong>
		<em class="sb16"><?php echo Helpers::t('appUi', 'Faixa de CEP 28890-001 a 28899-999.');?></em>

		<!--
		<div ng-show="false">
			<a class="twitter-timeline" href="https://twitter.com/hashtag/Delivery24hsRioDasOstras" data-widget-id="570196704839106560">Delivery24hsRioDasOstras Tweets</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		-->
	</article>
