<?php /* @var $this Controller */ ?>
<?php
    $this->beginContent('//layouts/main');
    $this->renderPartial('application.views.site.angularApp');
?>
<section class="ng-show" ng-hide="true">
    <div class="container-delivery text-center"><i class="fa fa-spinner fa-spin"></i> <?php echo Helpers::t('appUi','Carregando...'); ?></div>
</section>

<section class="main-body ng-hide" ng-controller="SiteController as site" ng-show="true">
    <div class="container-delivery">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
	</div>
</section>
<?php $this->endContent(); ?>

