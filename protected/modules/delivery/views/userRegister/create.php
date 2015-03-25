<?php
/* @var $this UserRegisterController */
/* @var $model User */

$this->breadcrumbs=array();

$this->menu=array();

//$this->renderPartial('app', array('model'=>$model,));
$this->renderPartial('angularUserRegister', array('model'=>$model,));
?>

<h1 class="st1 vt1"><?php echo Helpers::t('appUi', '{empresa} -  Novo Usuário',array('{empresa}'=>Yii::app()->name))?></h1>

<?php $this->renderPartial('_form', array(
		'model'=>$model,
		'modelParceiro'=>$modelParceiro,
		'modelAssign'=>$modelAssign,
)); ?>