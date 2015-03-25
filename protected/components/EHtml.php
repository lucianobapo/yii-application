<?php
class EHtml extends CHtml
{
    public static function activeRadioButtonList($model,$attribute,$data,$htmlOptions=array())
    {
        self::resolveNameID($model,$attribute,$htmlOptions);
        $selection=self::resolveValue($model,$attribute);
        if($model->hasErrors($attribute))
            self::addErrorCss($htmlOptions);
        $name=$htmlOptions['name'];
        unset($htmlOptions['name']);

        if(array_key_exists('uncheckValue',$htmlOptions))
        {
            $uncheck=$htmlOptions['uncheckValue'];
            unset($htmlOptions['uncheckValue']);
        }
        else
            $uncheck='';

        $hiddenOptions=isset($htmlOptions['id']) ? array('id'=>self::ID_PREFIX.$htmlOptions['id']) : array('id'=>false);
        //$hidden=$uncheck!==null ? self::hiddenField($name,$uncheck,$hiddenOptions) : '';
        $hidden=$uncheck!==null ? self::activeHiddenField($model,$attribute,$hiddenOptions) : '';
        //activeHiddenField($model,$attribute,$htmlOptions=array())

        return $hidden . self::radioButtonList($name,$selection,$data,$htmlOptions);
    }

}
