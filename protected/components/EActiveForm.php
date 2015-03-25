<?php
class EActiveForm extends CActiveForm
{
    public function radioButtonList($model,$attribute,$data,$htmlOptions=array())
    {
        return EHtml::activeRadioButtonList($model,$attribute,$data,$htmlOptions);
    }
}
