<?php /* @var $this Controller */ ?>
<?php
    $this->beginContent('//layouts/main');
    $this->renderPartial('application.views.site.angularApp');
?>
<section class="main-body" ng-controller="SiteController as site">
    <div class="container-delivery">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
	</div>
</section>
<?php $this->endContent(); ?>