Extensão para buscar endereço por CEP para o Yii Framework 
==========================================================

Versão: 1.0.5
-------------

A busca é realizada diretamente no website dos correios.

Demo
----

[http://wbraganca.com/yii-ext/demo-yii-correios/](http://wbraganca.com/yii-ext/demo-yii-correios/)

Instação e configuração
-----------------------

Copie a extensão para o diretório de extensões de sua aplicação: `extensions/correios`

Adicione no arquivo de configuração de sua aplicação o seguinte código.

	:::php
	<?php
		array(
			...
			'components'=>array(
				'buscaPorCep'=>array(
					'class'=>'ext.correios.BuscaPorCepApp'
				),
			...
		);
	?>

Usando
------

Crie uma action especifica para realizar a busca e adicione o código a seguir passando o cep
com parâmetro:

	:::php
		<?php $endereco = Yii::app()->buscaPorCep->run('12345-678'); ?>

Ou adicione no seu controller:

	:::php
		<?php
			public function actions()
			{
				return array(
					'buscaPorCep'=>'ext.correios.actions.BuscaPorCepAction'
				);
			}
		?>

Em seguinda adione na view:

	:::php
		<?php echo CHtml::button("Buscar endereço", array("id"=>"btnBuscarCep")); ?>

		<?php $this->widget('ext.correios.BuscaPorCep', array(
			'target'=>'#btnBuscarCep',
			'model'=>$modelEndereco,
			'attribute'=>'cep',
			'url'=>'/site/buscaPorCep',  
			'config'=>array(
				'location'=>'logradouro',
				'district'=>'bairro',
				'city'=>'cidade',
				'state'=>'estado',
			),
		)); ?>
