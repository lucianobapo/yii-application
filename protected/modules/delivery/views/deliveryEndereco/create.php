<?php
/* @var $this DeliveryEnderecoController */
/* @var $model DeliveryEndereco */

$this->breadcrumbs=array();

$this->menu=array();

$clientes=DeliveryParceiro::model()->findAllByAttributes(array(
    'empresa'=>'ilhanet',
    'tipo_cliente'=>1,
));

foreach($clientes as $cliente){
    $enderecos=DeliveryEndereco::model()->findAllByAttributes(array(
        'id_entidade'=>$cliente->id,
    ));
    if (count($enderecos)==0) {
        //echo ('<pre>'.CVarDumper::dumpAsString($cliente).'</pre>');
        $novoEndereco= new DeliveryEndereco();
        //$novoEndereco->empresa=$cliente;
        if (is_object($user=User::model()->findByAttributes(array('id_cliente'=>$cliente->id)))){
            $novoEndereco->usuario=$user->social_identifier;
            $novoEndereco->id_entidade=$cliente->id;
        $novoEndereco->cep=$cliente->cep;
        $novoEndereco->logradouro=$cliente->endereco;
        $novoEndereco->bairro=$cliente->custom3;
        $novoEndereco->cidade=$cliente->cidade;
        $novoEndereco->estado=$cliente->estado;
        $novoEndereco->complemento=$cliente->custom4;
        $novoEndereco->principal=1;

        $novoEndereco->save();
        //echo ('<pre>'.CVarDumper::dumpAsString($novoEndereco).'</pre>');
        }

    }
}



?>

    <h1><?php echo Helpers::t('appUi','{empresa} - Endereços',array('{empresa}'=>Yii::app()->name));?></h1>

<article>
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
</article>

    <?php $this->renderPartial('_form', array('model'=>$model)); ?>

