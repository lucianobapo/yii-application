<?php /* @var $this Controller */ ?>
<?php
    $this->beginContent('//layouts/main');
    $this->renderPartial('application.views.site.angularApp');
?>

    <section class="ng-show" ng-hide="true">
        <div class="container-delivery text-center"><i class="fa fa-spinner fa-spin"></i> <?php echo Helpers::t('appUi','Carregando...'); ?></div>
    </section>

    <section class="main-body ng-hide" ng-controller="SiteController as site" ng-show="true">

        <?php if (Yii::app()->params['boxSocial']): ?>
            <div class="container-delivery">
                <div class="box-top">
                    <span class="">Facebook:</span>
                    <span class=""><?php echo Helpers::getFacebookLike('botao2'); ?></span>
                </div>
                <div class="box-top">
                    <span class="">Google:</span>
                    <?php echo Helpers::getGoogleLike('botao2'); ?>
                </div>
            </div>

        <?php endif; ?>

        <div class="container-delivery">
            <div id="content">
                <?php echo $content; ?>
            </div><!-- content -->
        </div>
    </section>

<?php $this->endContent(); ?>