    <footer class="vb24">
        <div class="vb23">
            <div class="sb24">
                <ul class="list-inline">
                    <li class="">
                        <h5><?php echo Yii::app()->name;?></h5>
                        <ul class="sul1 vul1">
                            <li>
                                <?php echo Yii::app()->params['appSite'].Helpers::t('appUi',' - um site do grupo ').Yii::app()->params['companyLink'];?>
                            </li>
                            <li>
                                <?php echo Helpers::t('appUi','Contato:').' '.Yii::app()->params['adminEmailLink']; ?>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <h5><?php echo Helpers::t('appUi','Endereço'); ?></h5>
                        <ul class="sul1 vul1">
                            <li>
                                <?php echo Yii::app()->params['endereco'];?>
                            </li>
                            <li>
                                <?php echo Yii::app()->params['endereco2'];?>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <h5><?php echo Helpers::t('appUi','Redes sociais'); ?></h5>
                        <ul class="sul1 vul1">
                            <li>
                                <a class="spacing-borders" href="https://google.com/+Delivery24hsIlhaNET2010" target="_blank"><i class="fa fa-google-plus-square fa-4x"></i></a>
                                <a class="spacing-borders" href="https://www.facebook.com/riodasostrasdelivery24hs" target="_blank"><i class="fa fa-facebook-square fa-4x"></i></a>
                            </li>
                            <li>
                                <span id="siteseal" class="sub-img-responsive">
                                    <script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=oJAPresXla1NgP0UthgxbMYjntDn8O8gD1i5PZWz8scqJwPzGkJsScVN3W60"></script>
                                </span>
                            </li>
                        </ul>


                    </li>
                </ul>
            </div>
        </div>
        <div class="vb22">
            <div class="sb24">
                <?php echo Yii::app()->name;?> - <?php echo Yii::app()->params['site'];?>
                    Designed by <a href="http://www.webapplicationthemes.com" target="_blank">webapplicationthemes.com</a>.
                    All Rights Reserved.
                    <?php echo Yii::powered(); ?> v<?php echo Yii::getVersion();?>
                    and Twitter Bootstrap
            </div>
        </div>
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster
    <script type="text/javascript" src="<?php //echo Yii::app()->theme->baseUrl;?>/js/bootstrap-carousel.js"></script>
    <script type="text/javascript" src="<?php //echo Yii::app()->theme->baseUrl;?>/js/bootstrap-transition.js"></script>
    <script type="text/javascript" src="<?php //echo Yii::app()->theme->baseUrl;?>/js/bootstrap-dropdown.js"></script>
    <script type="text/javascript" src="<?php //echo Yii::app()->theme->baseUrl;?>/js/bootstrap-collapse.js"></script>
    <script type="text/javascript" src="<?php //echo Yii::app()->theme->baseUrl;?>/js/bootstrap-tab.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/css/tooltipster.min.css">
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/font-awesome430/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/bootstrap332/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/css/bootstrap-social.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/css/style1.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/css/template.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/css/delivery.css">
    -->

    <?php
    //$baseUrl = Yii::app()->theme->baseUrl;
    //$cs = Yii::app()->getClientScript();


    //* $_SERVER['HTTP_HOST']

    //$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/tooltipster.css');
    //$content = $content.file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/font-awesome430/css/font-awesome.css');;
    //$content = $content.file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/bootstrap332/css/bootstrap.css');
    //$content = $content.file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/bootstrap-social.css');
    //$content = $content.file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/style1.css');
    //$content = $content.file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/template.css');
    //$content = $content.file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/delivery.css');
    //$cs->registerCss(rand(),(Yii::app()->params['minifyCSS']? Minify_HTML::minifyCss($content):$content));
    //*/

    /*
    $cs->registerCss(rand(),Minify_HTML::minify(file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/tooltipster.css')));
    $cs->registerCss(rand(),Minify_HTML::minify(file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/font-awesome430/css/font-awesome.css')));
    $cs->registerCss(rand(),Minify_HTML::minify(file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/bootstrap332/css/bootstrap.css')));
    $cs->registerCss(rand(),Minify_HTML::minify(file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/bootstrap-social.css')));
    $cs->registerCss(rand(),Minify_HTML::minify(file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/style1.css')));

    $cs->registerCss(rand(),Minify_HTML::minify(file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/template.css')));
    $cs->registerCss(rand(),Minify_HTML::minify(file_get_contents($_SERVER['DOCUMENT_ROOT'].$baseUrl.'/css/delivery.css')));
    */
    //echo Helpers::getGoogleAnalytics();
    ?>

    </body>
</html>


