<?php
/* @var $this DeliveryEnderecoController */
/* @var $model DeliveryEndereco */
/* @var $form CActiveForm */
?>


    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'delivery-enderecos-grid',
        'htmlOptions'=>array('class'=>'table-responsive'),
        'itemsCssClass'=>'table table-striped table-hover ',
        'dataProvider'=>$model->search(),
        //'updateSelector'=>"{page}",
        //'filter'=>$model,
        'columns'=>array(
            'cep',
            'cidade',
            'estado',
            'bairro',
            'logradouro',
            'complemento',
            'obs',

            array(
                'class'=>'CButtonColumn',
                //'viewDialogEnabled'=>false,
                'template' => '{principalName}{principal}{update}{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'visible'=>'DeliveryEndereco::isOpen($data->id)&&(!DeliveryEndereco::isPrincipal($data->id))',
                        'url' => 'Yii::app()->createUrl(Helpers::getModuleName()."/deliveryEndereco/cancel", array("id"=>$data->id))',
                        'label' => '<i class="fa fa-times spacing-borders"></i>',//Helpers::t('app', 'Cancelar Pedido'),
                        'options'=> array('title'=>Helpers::t('app', 'Cancelar Endereço',array(),'i18n',null,false)),
                        'imageUrl' => false,
                    ),
                    'update'=>array(
                        'visible'=>'DeliveryEndereco::isOpen($data->id)&&(!DeliveryEndereco::isPrincipal($data->id))',
                        'label' => '<i class="fa fa-pencil spacing-borders"></i>',
                        'imageUrl' => false,
                        'options'=> array('title'=>Helpers::t('app', 'Revisar Endereço',array(),'i18n',null,false)),
                    ),
                    'principal'=>array(
                        'visible'=>'(!DeliveryEndereco::isPrincipal($data->id))',
                        'label' => '<i class="fa fa-check-square-o spacing-borders"></i>',
                        'imageUrl' => false,//Yii::app()->baseUrl . '/images/redo.png',
                        'options'=> array('title'=>Helpers::t('app', 'Marcar como Principal',array(),'i18n',null,false)),
                        'url' => 'Yii::app()->createUrl(Helpers::getModuleName()."/deliveryEndereco/principal", array("id"=>$data->id))',
                    ),
                    'principalName'=>array(
                        'visible'=>'(DeliveryEndereco::isPrincipal($data->id))',
                        'label' => Helpers::t('app', 'Principal',array(),'i18n',null,false),
                        'imageUrl' => false,//Yii::app()->baseUrl . '/images/redo.png',
                        'options'=> array('title'=>Helpers::t('app', 'Endereço Principal',array(),'i18n',null,false),'style'=>'text-decoration: none'),
                        'url' => '',//'Yii::app()->createUrl(Helpers::getModuleName()."/deliveryEndereco/principal", array("id"=>$data->id))',
                    ),
                ),

            ),
        ),
    )); ?>




<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'delivery-endereco-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'htmlOptions'=> array(
		'novalidate' => 'novalidate',
		//'role'=>'form',
        //'class'=>"form-horizontal",
		'verifica'=>Helpers::t('appUi','Este endereço ainda não foi gravado!',array(),'i18n',null,false),
	),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Helpers::t('app', 'appFormLabel1',array(),'i18n',null,false); ?></p>

    <?php
    $errors=array();
    if (isset($model)) array_push($errors,$model);
    echo $form->errorSummary(
        $errors,
        '<button type="button" class="close" data-dismiss="alert">&times;</button>'.
        '<p>'.Yii::t('yii','Please fix the following input errors:').'</p>',
        null,
        array('class'=>'alert alert-danger')
    );
    ?>

    <?php
        $modelCache= new DbAccess();
        echo $form->hiddenField($model,'id_entidade',array('value'=>$modelCache->getParceiro(Yii::app()->user->social_identifier)->id_cliente ) );
    //$modelCache->getParceiro(Yii::app()->user->social_identifier)->id_cliente
    //echo ('<pre>'.CVarDumper::dumpAsString($modelCache->getParceiro(Yii::app()->user->social_identifier)).'</pre>');
    ?>

    <div class="form-block-delivery">
        <div class="form-inline-delivery col-sm-3 has-feedback">
            <?php echo $form->labelEx($model,'cep'); ?>
            <?php echo $form->textField($model,'cep',array('maxlength'=>8,'class'=>'form-control numbersOnly','placeholder'=>Helpers::t('appUi', '28890001 a 28899999'))); ?>
            <span id="<?php echo CHtml::activeID($model, 'cep');?>_loading" class="form-control-feedback ng-hide"><i class="fa fa-spinner fa-spin"></i></span>
        </div>

        <?php $this->widget('ext.correios.BuscaPorCep', array(
            'jsAction'=>'blur',
            'target'=>'#'.CHtml::activeID($model, 'cep'),//'#btnBuscarCep',
            'model'=>$model,
            'attribute'=>'cep',
            'url'=>'/' . Helpers::getModuleName() .'/deliveryEndereco/buscaPorCep',
            'config'=>array(
                'location'=>'logradouro',
                'district'=>'bairro',
                'city'=>'cidade',
                'state'=>'estado',
            ),
        )); ?>
    </div>

    <div class="form-block-delivery">
        <div class="form-inline-delivery col-sm-3">
            <?php echo $form->labelEx($model,'logradouro'); ?>
            <?php echo $form->textField($model,'logradouro',array('class'=>'form-control','size'=>60,'maxlength'=>255,'placeholder'=>Helpers::t('appUi', 'Ex.: Rua, Av, Est, etc..'))); ?>
        </div>

        <div class="form-inline-delivery col-sm-3">
            <?php echo $form->labelEx($model,'bairro'); ?>
            <?php echo $form->textField($model,'bairro',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
        </div>
    </div>
    <div class="form-block-delivery">
        <div class="form-inline-delivery col-sm-3">
            <?php echo $form->labelEx($model,'cidade'); ?>
            <?php echo $form->textField($model,'cidade',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
        </div>

        <div class="form-inline-delivery col-sm-3">
            <?php echo $form->labelEx($model,'estado'); ?>
            <?php echo $form->textField($model,'estado',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
        </div>
    </div>
    <div class="form-block-delivery">
        <div class="form-inline-delivery col-sm-3">
            <?php echo $form->labelEx($model,'complemento'); ?>
            <?php echo $form->textField($model,'complemento',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
        </div>
        <div class="form-inline-delivery col-sm-3">
            <?php echo $form->labelEx($model,'obs'); ?>
            <?php echo $form->textField($model,'obs',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
        </div>
    </div>

	<div class="form-block-delivery buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Helpers::t('app', 'Criar Endereço',array(),'i18n',null,false) : Helpers::t('app', 'Salvar Endereço',array(),'i18n',null,false),array('class'=>'btn btn-large btn-success','click-once'=>Helpers::t('app', 'Carregando...')) ); ?>
		<?php echo $form->hiddenField($model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
	</div>

<?php $this->endWidget(); ?>

<!-- form -->