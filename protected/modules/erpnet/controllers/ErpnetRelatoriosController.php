<?php

class ErpnetRelatoriosController extends Controller
{
	private $linhas=array();
	private $linhasFatura=array();
	private $linhasPagar=array();
	private $colunas=array();
	private $model=null;
	private $linhaTanque=array();
	private $linhaProdutor=array();
	private $linhaTotal=array();
	private $linhaSaldo=array();
	private $linhaColetas=array();
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('index'),
                'users'=>array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('relatorioTanque'),
                'roles'=>array('erpnetViewRelatorioTanque'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('relatorioContas'),
                'roles'=>array('erpnetViewRelatorioContas'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('graficos'),
                'roles'=>array('erpnetViewRelatorioContas'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
		);
	}
	
	private function zeraItem(&$item) {
		$item['entrada']=0;
		$item['saida']=0;
	
		for ($i=CDateTimeParser::parse ( $this->model->data_inicial, Yii::app ()->locale->dateFormat );
		$i<strtotime("+1 day",CDateTimeParser::parse ( $this->model->data_final, Yii::app ()->locale->dateFormat ));
		$i=strtotime("+1 day",$i))
			$item [$i]=0;
		return true;
	
	}
	
	private function calculaEstoque(&$produtor=null,$tipo=null,$turno=null,&$debug=null) {
		if ($produtor===null) return false;
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'empresa', Yii::app ()->user->empresa );
		if ($turno!==null) $criteria->compare ( 'turno', $turno );
		$criteria->compare ( 'id_wbs', $produtor->id );
		$criteria->compare ( 'id_produto', $this->model->produto );
		
		$criteria->addBetweenCondition ( 'data_movimento', 
				CDateTimeParser::parse ( $this->model->data_inicial, Yii::app ()->locale->dateFormat ), 
				CDateTimeParser::parse ( $this->model->data_final, Yii::app ()->locale->dateFormat ) );
		$criteria->addCondition("id_ordem IS NOT NULL");
		if ( ( ($erpnetEstoque = ErpnetEstoque::model ()->findAll ( $criteria ))!==null ) 
			&& (ErpnetEstoque::model ()->count ( $criteria )>0) ) {
			
			foreach ( $erpnetEstoque as $key => $estoque ) {
				if ($tipo=='entrada') {
				//soma o total geral de entradas
				$this->linhaTotal [$tipo] = $this->linhaTotal  [$tipo] + $estoque->quantidade;
				
				//soma o total de entradas do tanque
				$this->linhaTanque [$tipo] = $this->linhaTanque  [$tipo] + $estoque->quantidade;
				
				// calcula o detalhe dos dias
				if ($this->model->detalhe_dia) {
					$this->linhaTotal  [$estoque->data_movimento] = $this->linhaTotal  [$estoque->data_movimento] + $estoque->quantidade;
					$this->linhaTanque  [$estoque->data_movimento] = $this->linhaTanque  [$estoque->data_movimento] + $estoque->quantidade;
					
				}
					
				// calcula o detalhe dos produtores
				if ($this->model->detalhe_produtor){
					$this->linhaProdutor [$tipo] = $this->linhaProdutor [$tipo] + $estoque->quantidade;
					if ($this->model->detalhe_dia) 
						$this->linhaProdutor [$estoque->data_movimento] = $this->linhaProdutor [$estoque->data_movimento] + $estoque->quantidade;
				
				}
				}elseif ($tipo=='saida') {
					//soma o total geral de saidas
					$this->linhaTotal [$tipo] = $this->linhaTotal  [$tipo] + $estoque->quantidade;
					
					//soma o total de saidas do tanque
					$this->linhaColetas [$tipo] = $this->linhaColetas  [$tipo] + $estoque->quantidade;
					
					// calcula o detalhe dos dias
					if ($this->model->detalhe_dia) {
						//$this->linhaTotal  [$estoque->data_movimento] = $this->linhaTotal  [$estoque->data_movimento] + $estoque->quantidade;
						$this->linhaColetas  [$estoque->data_movimento] = $this->linhaColetas  [$estoque->data_movimento] + $estoque->quantidade;
							
					}
					
				}
				
			}
			return true;
		} else return false;
	}
	
	private function calculaProdutor(&$tanque=null,&$debug=null) {
		if ($tanque===null) return false;
		if ( ($erpnetProdutor=ErpnetWbs::model ()->findAllByAttributes(array(
				'empresa'=>Yii::app ()->user->empresa,
				'tipo'=>'producao',
				'id_pai'=>$tanque->id,
				
		)) )!==null ) {
			foreach ( $erpnetProdutor as $key => $produtor ) {
				$this->zeraItem($this->linhaProdutor);
				if ($this->calculaEstoque($produtor,'entrada','tarde',$debug)) {
					$this->linhaProdutor['descricao']=$produtor->concatened;
					$this->linhaProdutor['turno']='T';
					if ($this->model->detalhe_produtor) array_push ( $this->linhas, $this->linhaProdutor );
				}
				$this->zeraItem($this->linhaProdutor);
				$this->calculaEstoque($produtor,'entrada','manha',$debug);
				$this->linhaProdutor['descricao']=$produtor->concatened;
				$this->linhaProdutor['turno']='M';
				if ($this->model->detalhe_produtor) array_push ( $this->linhas, $this->linhaProdutor );
			}
			return true;
		} else return false;
	}
	private function preencheProducao(&$debug=null){
		if ($this->model===null) return false;
		$this->zeraItem($this->linhaTotal);
		
		if (ErpnetWbs::model ()->countByAttributes(array('id'=>$this->model->tanque))==1)
			$erpnetTanques=ErpnetWbs::model ()->findAllByAttributes(array('id'=>$this->model->tanque));
		else 
			$erpnetTanques=ErpnetWbs::model ()->findAllByAttributes(array(
				'empresa'=>Yii::app ()->user->empresa,
				'tipo'=>'estoque',
			));
		foreach ( $erpnetTanques as $key => $tanque ) {
			$this->zeraItem($this->linhaSaldo);
			
			$this->zeraItem($this->linhaTanque);
			$this->calculaProdutor($tanque,$debug);
			$this->linhaTanque['descricao']='Total: '.$tanque->concatened;
			//$this->linhaSaldo['entrada']=$this->linhaTanque['entrada'];
			array_push ( $this->linhas, $this->linhaTanque );
			
			$this->zeraItem($this->linhaColetas);
			$this->calculaEstoque($tanque,'saida',null,$debug);
			$this->linhaColetas['descricao']='Coletas: '.$tanque->concatened;
			//$this->linhaSaldo['saida']=$this->linhaColetas['saida'];
			array_push ( $this->linhas, $this->linhaColetas );
			
			$saldoAnterior=0;
			for ($i=CDateTimeParser::parse ( $this->model->data_inicial, Yii::app ()->locale->dateFormat );
				$i<strtotime("+1 day",CDateTimeParser::parse ( $this->model->data_final, Yii::app ()->locale->dateFormat ));
				$i=strtotime("+1 day",$i)) {
					$this->linhaSaldo[$i]=$this->linhaTanque[$i]+$this->linhaColetas[$i]+$saldoAnterior;
					$saldoAnterior=$this->linhaSaldo[$i];
				}
			$this->linhaSaldo['descricao']='Acumulado: '.$tanque->concatened;
			$this->linhaSaldo['saldo']=$this->linhaTanque['entrada']+$this->linhaColetas['saida'];
			array_push ( $this->linhas, $this->linhaSaldo );
		}
		$this->linhaTotal['descricao']=utf8_encode('Produ��o Geral');
		array_push ( $this->linhas, $this->linhaTotal );
	}
		
	public function actionRelatorioTanque()
	{
		function processa_notas(&$obs,$model,$wbs=null){
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'empresa', Yii::app ()->user->empresa );
			if ($wbs!==null) $criteria->compare ( 'id_wbs', $wbs );
			$criteria->compare ( 'id_produto', $model->produto );
			
			$criteria->addBetweenCondition ( 'data_movimento',
					CDateTimeParser::parse ( $model->data_inicial, Yii::app ()->locale->dateFormat ),
					CDateTimeParser::parse ( $model->data_final, Yii::app ()->locale->dateFormat ) );
			$criteria->addCondition("id_ordem IS NULL");
			if ( ($erpnetEstoque = ErpnetEstoque::model ()->findAll ( $criteria ))!==null ) {
				//$obs=$obs.'<pre>'.CVarDumper::dumpAsString($erpnetEstoque).'</pre>';
				foreach ($erpnetEstoque as $key => $value) {
					$obs=$obs.$value->descricao_wbs.' : Em '.Yii::app()->dateFormatter->formatDateTime($value->data_movimento,'medium',null)
					.', ajuste de quantidade '.$value->quantidade.' : '.$value->obs.'<br>';
				}
			}
		}
		
		$this->model = new ErpnetRelatoriosForm ();
		$itens = array ();
		
		if (isset ( $_POST ['ErpnetRelatoriosForm'] )) {
			$this->model->attributes = $_POST ['ErpnetRelatoriosForm'];
			
			if ($this->model->validate ()) {
			//if (($this->model->validate ()) && ($this->preencheProducao ( $debug ))) {
				
				$this->preencheProducao ( $debug );
				array_push ( $itens, array (
						'name' => 'descricao',
						'header' => 'Tanque',
						'htmlOptions'=>array(
								'border'=>1,
						),
				), array (
						'name' => 'turno',
						'header' => 'Turno',
						'htmlOptions'=>array(
								'border'=>1,
						),
				) );
				if ($this->model->detalhe_dia)
					for($i=CDateTimeParser::parse ( $this->model->data_inicial, Yii::app ()->locale->dateFormat );
							$i<strtotime("+1 day",CDateTimeParser::parse ( $this->model->data_final, Yii::app ()->locale->dateFormat ));
							$i=strtotime("+1 day",$i))
						array_push ( $itens, array (
								'name' => $i,
								'header' => date ( 'd',$i),
								'htmlOptions'=>array(
										'border'=>1,
								),
						) );
				array_push ( $itens, array (
						'name' => 'entrada',
						'header' => utf8_encode ( 'Prod.' ),
						'htmlOptions'=>array(
								'border'=>1,
						),
				), array (
						'name' => 'saida',
						'header' => 'Coleta',
						'htmlOptions'=>array(
								'border'=>1,
						),
				), array (
						'name' => 'saldo',
						'header' => 'Saldo',
						'htmlOptions'=>array(
								'border'=>1,
						),
				) );
				//$debug=$itens;
			}
		}
		
		$gridDataProvider = new CArrayDataProvider ( $this->linhas );
		$subtitle=utf8_encode('Per�odo entre '.$this->model->data_inicial.' e '.$this->model->data_final.'<br>');
		if ($this->model->tanque!='') $subtitle=$subtitle.'Tanque: '.ErpnetWbs::model()->findByPk($this->model->tanque)->concatened.'<br>';
		if ($this->model->produto!='') $subtitle=$subtitle.'Produto: '.ErpnetProduto::model()->findByPk($this->model->produto)->concatened.'<br>';
		
		$obs='Notas:<br>';
		if ($this->model->tanque!='') {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'empresa', Yii::app ()->user->empresa );
			$criteria->compare ( 'id_pai', $this->model->tanque );
			$criteria->compare ( 'tipo', 'producao' );
			if ( ($erpnetWbs = ErpnetWbs::model ()->findAll ( $criteria ))!==null ) {
				//$obs='<pre>'.CVarDumper::dumpAsString($erpnetWbs).'</pre>';
				foreach ($erpnetWbs as $key => $value) {
					processa_notas($obs,$this->model,$value->id);
				}
			}
			
		} else processa_notas($obs,$this->model);
		
		//$obs='<pre>'.CVarDumper::dumpAsString($this->model).'</pre>';

		if ( (isset ($_POST ['ErpnetRelatoriosForm']['exportar_excel']))&&($_POST ['ErpnetRelatoriosForm']['exportar_excel']==true) ) {
			set_time_limit(90);
			$html2pdf = Yii::app()->ePdf->HTML2PDF('L','A3');
			$html2pdf->WriteHTML($this->renderPartial('_tabela', array (
				'model' => $this->model,
				'gridDataProvider' => $gridDataProvider,
				'itens' => $itens,
				'subtitle'=>$subtitle,
				'obs' => utf8_encode($obs),
			), true));
			$html2pdf->Output('relatorio.pdf','D');
		}
		$this->render ( 'relatorioGeralTanque', array (
				'model' => $this->model,
				'gridDataProvider' => $gridDataProvider,
				'itens' => $itens,
				'mostra' => $debug, 
				'obs' => utf8_encode($obs),
		) );
	}
	
	public function actionRelatorioContas()
	{
		$this->model = new ErpnetRelatoriosForm ();
		$itens = array ();
		$inicial='01/'.date('m/Y');
		$final=date('d/m/Y',strtotime("-1 day",strtotime("+1 month",mktime(null,null,null,date('m'),'1',date('y')) )));
		
		if (isset ( $_POST ['ErpnetRelatoriosForm'] )) {
			
			$this->model->attributes = $_POST ['ErpnetRelatoriosForm'];
			$inicial=$this->model->data_inicial;
			$final=$this->model->data_final;
			
			if (($this->model->validate ())) {
				
				//Preenche dados de estoque
				$saldo=0;
				$criteria = new CDbCriteria ();
				if (! Yii::app ()->user->checkAccess ( 'admin' ))
					$criteria->compare ( 'empresa', Yii::app ()->user->empresa );
				$criteria->addBetweenCondition ( 'data_movimento', 
						CDateTimeParser::parse ( $this->model->data_inicial, Yii::app ()->locale->dateFormat ), 
						CDateTimeParser::parse ( $this->model->data_final, Yii::app ()->locale->dateFormat ) );
				$criteria->order='data_movimento';
				$criteria->compare ( 'id_produto', $this->model->produto );
				$criteria->compare ( 'id_wbs', $this->model->tanque );
				$debug=$criteria;
				$erpnetEstoque = ErpnetEstoque::model ()->findAll ( $criteria );
				$erpnetEstoqueCount = ErpnetEstoque::model ()->count ( $criteria );
				if ($erpnetEstoqueCount > 0) 
					foreach ( $erpnetEstoque as $key => $estoque ){
						array_push ( $this->linhas, array(
							'id'=>$estoque->id,
							'data_movimento'=>Yii::app()->dateFormatter->formatDateTime($estoque->data_movimento,'medium',null),
							'quantidade'=>$estoque->quantidade,
							'descricao'=>$estoque->descricao_wbs,
							'produto'=>ErpnetProduto::model()->findByPk($estoque->id_produto)->concatened,
						) );
						$saldo=$saldo+$estoque->quantidade;
					}
				array_push( $this->linhas, array('id'=>'Saldo','quantidade'=>$saldo) );
				/*
				//*/
				//Preenche dados de contas a Receber
				$saldoFatura=0;
				$criteria = new CDbCriteria ();
				if (! Yii::app ()->user->checkAccess ( 'admin' ))
					$criteria->compare ( 'empresa', Yii::app ()->user->empresa );
				$criteria->addBetweenCondition ( 'data_movimento', 
						CDateTimeParser::parse ( $this->model->data_inicial, Yii::app ()->locale->dateFormat, array('hour'=>0, 'minute'=>0, 'second'=>0) ), 
						CDateTimeParser::parse ( $this->model->data_final, Yii::app ()->locale->dateFormat, array('hour'=>0, 'minute'=>0, 'second'=>0) ) );
				$criteria->order='data_movimento';
				$criteria->compare ( 'id_produto', $this->model->produto );
				$criteria->compare ( 'id_wbs', $this->model->tanque );
				//$debug=$criteria;
				$erpnetFatura = ErpnetFatura::model ()->findAll ( $criteria );
				$erpnetFaturaCount = ErpnetFatura::model ()->count ( $criteria );
				if ($erpnetFaturaCount > 0)
					foreach ( $erpnetFatura as $key => $estoque ){
						array_push ( $this->linhasFatura, array(
							'id'=>$estoque->id,
							'data_movimento'=>Yii::app()->dateFormatter->formatDateTime($estoque->data_movimento,'medium',null),
							//date('d/m/Y',strtotime($estoque->data_movimento)),
							'quantidade'=>$estoque->quantidade,
							'valor'=>Yii::app()->numberFormatter->formatCurrency(($estoque->valor*Helpers::getQuote(time(),$estoque->moeda)*$estoque->quantidade),Yii::app()->locale->getCurrencySymbol('BRL')),
							'descricao'=>$estoque->descricao_wbs,
							'produto'=>ErpnetProduto::model()->findByPk($estoque->id_produto)->concatened,
						) );
						$saldoFatura=$saldoFatura+($estoque->valor*Helpers::getQuote(time(),$estoque->moeda)*$estoque->quantidade);
					}
				array_push( $this->linhasFatura, array('id'=>'Saldo','valor'=>Yii::app()->numberFormatter->formatCurrency($saldoFatura,Yii::app()->locale->getCurrencySymbol('BRL'))) );
				
				
				//Preenche dados de contas a Pagar
				$saldoPagar=0;
				$criteria = new CDbCriteria ();
				if (! Yii::app ()->user->checkAccess ( 'admin' ))
					$criteria->compare ( 'empresa', Yii::app ()->user->empresa );
				$criteria->addBetweenCondition ( 'data_movimento', 
						CDateTimeParser::parse ( $this->model->data_inicial, Yii::app ()->locale->dateFormat ), 
						CDateTimeParser::parse ( $this->model->data_final, Yii::app ()->locale->dateFormat ) );
				$criteria->order='data_movimento';
				$criteria->compare ( 'id_produto', $this->model->produto );
				$criteria->compare ( 'id_wbs', $this->model->tanque );
				$erpnetPagar = ErpnetPagar::model ()->findAll ( $criteria );
				$erpnetPagarCount = ErpnetPagar::model ()->count ( $criteria );
				if ($erpnetPagarCount > 0)
				foreach ( $erpnetPagar as $key => $estoque ){
					array_push ( $this->linhasPagar, array(
						'id'=>$estoque->id,
						'data_movimento'=>Yii::app()->dateFormatter->formatDateTime($estoque->data_movimento,'medium',null),
						'quantidade'=>$estoque->quantidade,
						'valor'=>Yii::app()->numberFormatter->formatCurrency(($estoque->valor*Helpers::getQuote(time(),$estoque->moeda)*$estoque->quantidade),Yii::app()->locale->getCurrencySymbol('BRL')),
						'valorUnitario'=>Yii::app()->numberFormatter->formatCurrency(($estoque->valor*Helpers::getQuote(time(),$estoque->moeda)),Yii::app()->locale->getCurrencySymbol('BRL')),
						'descricao'=>$estoque->descricao_wbs,
						'produto'=>ErpnetProduto::model()->findByPk($estoque->id_produto)->concatened,
					) );
					$saldoPagar=$saldoPagar+($estoque->valor*Helpers::getQuote(time(),$estoque->moeda)*$estoque->quantidade);
				}
				array_push( $this->linhasPagar, array('id'=>'Saldo','valor'=>Yii::app()->numberFormatter->formatCurrency($saldoPagar,Yii::app()->locale->getCurrencySymbol('BRL'))) );
				
				
				
				array_push ( $itens, array (
						'name' => 'id',
						'header' => 'Movimento' 
				), array (
						'name' => 'data_movimento',
						'header' => 'Data' 
				) );
				array_push ( $itens, array (
					'name' => 'descricao',
					'header' => Helpers::t('appUi','Objeto')
				) );
				array_push ( $itens, array (
					'name' => 'produto',
					'header' => Helpers::t('appUi','Produto' )
				) );
				array_push ( $itens, array (
						'name' => 'quantidade',
						'header' => Helpers::t('appUi','Quantidade' )
				) );
				array_push ( $itens, array (
					'name' => 'valorUnitario',
					'header' => Helpers::t('appUi','Valor Unitário' )
				) );
				array_push ( $itens, array (
					'name' => 'valor',
					'header' => Helpers::t('appUi','Valor Total' )
				) );
			}
			
		}
		
		// *
		$gridDataProvider = new CArrayDataProvider ( $this->linhas );
		$modelFatura = new CArrayDataProvider ( $this->linhasFatura );
		$modelPagar = new CArrayDataProvider ( $this->linhasPagar );
		$this->render ( 'relatorioContas', array (
				'model' => $this->model,
				'gridDataProvider' => $gridDataProvider,
				'modelFatura' => $modelFatura,
				'modelPagar' => $modelPagar,
				'itens' => $itens,
				'saldo' => $saldo,
				'saldoFatura' => $saldoFatura,
				'saldoPagar' => $saldoPagar,
				'inicial' => $inicial,
				'final' => $final,
				'debug'=>$debug,
		) );
	}
	
	public function actionIndex()
	{
		$this->render('home');
	}

    public function actionGraficos()
    {
        $this->render('graphs');
    }
}