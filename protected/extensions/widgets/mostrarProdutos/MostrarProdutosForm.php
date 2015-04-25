<?php
class MostrarProdutosForm extends CWidget {
	
	public $form=null;
	public $model=null;
	public $modelItem=null;

	/**
	 *
     */
	public function run() {
		//Yii::import('application.modules.erpnet.models.ErpnetGrupoProduto');
		$produtos=ErpnetProduto::getProdutos();
		//$produtos->findAllByAttributes(array('empresa'=>'ilhanet','ativado'=>1));
		//$produtos->erpnetGrupoProdutos
		//die ('<pre>'.CVarDumper::dumpAsString($produtos).'</pre>');
		//$destaques=ErpnetProduto::getDestaque();
		
		$id_cliente=User::model()->findByAttributes(array('social_identifier'=>Yii::app()->user->social_identifier))->id_cliente;
		//$destaques=ErpnetProduto::model()->findAllByAttributes(array('empresa'=>'ilhanet','destaque'=>1));
		//echo '<pre>'.CVarDumper::dumpAsString($destaques).'</pre>';
?>

<?php if (isset($this->model)) echo $this->form->errorSummary($this->model); ?>
<?php if (isset($this->modelItem)) foreach ($this->modelItem as $key=>$value) echo $this->form->errorSummary($value); ?>

<?php echo $this->form->hiddenField($this->model,'empresa',array('value'=>Yii::app()->user->empresa)) ?>
<?php echo $this->form->hiddenField($this->model,'status_fechado',array('value'=>'0')) ?>
<?php echo $this->form->hiddenField($this->model,'id_cliente',array('value'=>$id_cliente)) ?>
<?php echo $this->form->hiddenField($this->model,'tipo',array('value'=>'orcamentoVenda')) ?>
<?php echo $this->form->hiddenField($this->model,'usuario',array('value'=>Yii::app()->user->social_identifier)) ?>

<script type='text/javascript'>
	$(document).ready(
		function () {
			valores=[];
			valor_unitario=[];
		});
</script>
<div class="row-fluid">
<?php 
		$index=0;
		$mudacoluna= (count($produtos)+(count($produtos) % 2))/2;
		foreach($produtos as $destaque) {
			if (($index % $mudacoluna)==0) echo '<div class="span6">';
			?>
                <div class="square-background clearfix">
                                  
                  	<div class="square square-back pull-left"  style="width: 60px">
                		<img src="<?php echo Yii::app()->baseUrl . '/images/'.$destaque->id;?>-thumb.png" alt="" class="">
                     </div>
                  
                  <h4><?php echo $destaque->descricao;?></h4>
                  <div class="controls-row">
                  	<p class="span5"><?php echo Helpers::t('appUi', 'Valor unitário: ').CHtml::encode(Yii::app()->numberFormatter->formatCurrency($destaque->valor,'R$'));?></p>
					  <?php
					  if (ErpnetProduto::temEstoque($destaque->id))
						  echo $this->form->numberField($this->modelItem[$index], "[$index]quantidade", array(
							  'maxlength' => 2,
							  'class' => 'span2',
							  'min' => 0,
							  'max' => ErpnetProduto::saldoEstoque($destaque->id),
						  ));
					  else
						  echo '<spam class="text-error">'.Helpers::t('appUi','Produto indisponível no momento').'</spam>';
					  $attribute = "[$index]quantidade";
					  $htmlOptions = array();
					  CHtml::resolveNameID($this->modelItem[$index], $attribute, $htmlOptions);
					  ?><br>
                  	<span id="errmsg_quantidade<?php echo $index; ?>" class="errorMessage"></span>
                  	
       	<script type='text/javascript'>
		$(document).ready(
		function () {
			valor_unitario[<?php echo $index;?>]=<?php echo $destaque->valor;?>;
			valores[<?php echo $index;?>]=parseFloat($("#<?php echo $htmlOptions['id'];?>").val())*valor_unitario[<?php echo $index;?>];
			//called when key is pressed in textbox
			$("#<?php echo $htmlOptions['id'];?>").keypress(
				function (e) {
			     	//if the letter is not digit then display error and don't type anything
			    	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			        	//display error message
			       		$("#errmsg_quantidade<?php echo $index; ?>").html("Digite apenas n&uacutemeros").show().fadeOut(3000);
			            return false;
			    	}
			    	if (this.value.length > 1) return false;			    			    
		    	}
		    )
			$("#<?php echo $htmlOptions['id'];?>").blur(function () {
				valores[<?php echo $index;?>]=parseFloat(this.value)*valor_unitario[<?php echo $index;?>];
				var total=0;
				$.each(valores,function(){total+=parseFloat(this) || 0;});
				total=total.toFixed(2);
				$("#valor_total").html("Valor Total: ").show();
				$("#valor_total2").html(total).show();
				$("#valor_total3").html("Valor Total: ").show();
				$("#valor_total4").html(total).show();
				$('#valor_total2').priceFormat({
  					prefix: 'R$ ',
				    centsSeparator: ',',
    				thousandsSeparator: '.',
				;});
				$('#valor_total4').priceFormat({
  					prefix: 'R$ ',
				    centsSeparator: ',',
    				thousandsSeparator: '.',
				});
			});
		});
		</script>
                  	<?php echo $this->form->hiddenField($this->modelItem[$index],"[$index]empresa",array('value'=>Yii::app()->user->empresa)) ?>
					<?php echo $this->form->hiddenField($this->modelItem[$index],"[$index]id_produto",array('value'=>$destaque->id)) ?>
					<?php echo $this->form->hiddenField($this->modelItem[$index],"[$index]usuario",array('value'=>Yii::app()->user->social_identifier)) ?>
                  </div>
                </div>
                
			<?php 
			if ( (($index % $mudacoluna)==$mudacoluna-1)|| (count($this->modelItem)-1==$index) ) echo '</div>';
			$index=$index+1;
		}
?>
</div>


<?php 	
	}
}
?>