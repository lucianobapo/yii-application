
<div class="sb16">
    <p><strong><?php echo Helpers::t('appUi', 'Valor Total:'); ?> {{createCtrl.getTotal()|currency}}</strong></p>
</div>

<input type="hidden" name="{{createCtrl.moduleItems.id_clienteName}}" value="{{createCtrl.moduleItems.id_clienteValor}}">
<input type="hidden" name="{{createCtrl.moduleItems.status_fechadoName}}" value="0">
<input type="hidden" name="{{createCtrl.moduleItems.tipoName}}" value="orcamentoVenda">

<div class="sb16">
    <product-panels>
        <?php $this->renderPartial('/default/product-panel'); ?>
    </product-panels>
</div>

<div class="panel panel-primary sb17">
    <div class="panel-heading">{{createCtrl.labelFormaPagamento}}</div>
    <div class="panel-body">
        <strong><?php echo Helpers::t('appUi', 'Valor Total:'); ?> {{createCtrl.getTotal()|currency}}</strong>


        <ul class="list-group">
            <li class="list-group-item">
                <?php
                $pagamentos['vistad']=Helpers::t('appUi','Dinheiro');
                if (Yii::app()->params['cartaoDebito']) $pagamentos['vistacd']='<span class="payleven">'.Helpers::t('appUi','Cartao de Débito').'</span>';
                if (Yii::app()->params['cartaoCredito']) $pagamentos['vistacc']=' <span class="payleven">'.Helpers::t('appUi','Cartao de Crédito').'</span>';
                echo $form->radioButtonList($modelOrdem,'pagamento',$pagamentos,array(
                    'ng-model'=>"valor",
                    'ng-init'=>"valor='".$modelOrdem->pagamento."'",
                    'template'=>'{beginLabel}{input} {labelTitle}{endLabel}',
                ) ); ?>
                <div class="col-sm3" ng-show="valor=='vistad'">
                    <?php echo $form->labelEx($modelOrdem,'troco',array('label'=>Helpers::t('appUi', 'Levar troco para')))?>
                    <div class="input-group">
                        <div class="input-group-addon">R$</div>
                        <?php echo $form->textField($modelOrdem,'troco',array('class'=>'priceFormat form-control','maxlength'=>6,'ng-disabled'=>"valor!='vistad'"))?>
                    </div>
                </div>
                <div class="col-sm3" ng-show="valor=='vistacd' || valor=='vistacc'">
                    <!-- <img class="img-responsive" src="/images/credit_cards.png"> -->
                    <i class="fa fa-cc-visa fa-3x spacing-borders"></i><i class="fa fa-cc-mastercard fa-3x spacing-borders"></i><i class="fa fa-cc-discover fa-3x spacing-borders"></i>
                </div>
            </li>
        </ul>
    </div>
</div>

<!--
    <div class="sb16" ng-show="createCtrl.pagSeguro">
        <p class="span2" align=center>-- ou --</p>
    </div>

    <div class="sb16" ng-show="createCtrl.pagSeguro">
        <a href="#" class="span2" align=left>
            <input type="image" name="submit" value="pagseguro"
                   alt="{{createCtrl.labelPagSeguro}}"
                   src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif">
        </a>
    </div>
-->
    <em class="sb16"><?php echo Helpers::t('appUi', 'Em breve novas formas de pagamento. Ex. PayPal, PagSeguro, etc...'); ?></em>

<div class="sb16 buttons">
    <input class="btn btn-large btn-success" click-once="{{createCtrl.labelCarregando}}" type="submit" id="envio" name="yt1" value="{{createCtrl.labelBtnEnviar}}" />
</div>