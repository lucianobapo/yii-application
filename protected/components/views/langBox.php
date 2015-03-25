<?php echo CHtml::form(); ?>
    <div id="langdrop" class="navbar-search pull-right">
        <?php echo Yii::t('app', 'appLang', array(), 'i18n').' '.CHtml::dropDownList('_lang', $currentLang,$linguagens , array('class'=>'search-query span2','submit' => '')); ?>
    </div>
<?php echo CHtml::endForm(); ?>