<?php
// Inicia buffer
ob_start();

// Require the header
require_once('tpl_header.php');

// Require the navigation
require_once('tpl_navigation.php');

// Include content pages
echo $content;

// Require the footer
require_once('tpl_footer.php');

//Armazena o buffer
$out1 = ob_get_contents();
//finaliza e limpa o buffer
ob_end_clean();

echo (Yii::app()->params['minifyHTML']? Minify_HTML::minify($out1):$out1);
//echo Minify_HTML::minify($out1);