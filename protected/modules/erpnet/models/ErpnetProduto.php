<?php

/**
 * This is the model class for table "erpnet_produto".
 *
 * The followings are the available columns in table 'erpnet_produto':
 * @property integer $id
 * @property string $empresa
 * @property string $cod_fiscal
 * @property string $descricao
 * @property string $uom
 */
class ErpnetProduto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_produto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$regras= array(
			array('empresa, descricao, uom', 'required'),
			array('cod_barra, fabricante, obs, ativado', 'safe'),
			array('valor, valor_venda, valor_promocao, estoque_minimo', 'numerical'),
			array('moeda', 'length', 'max'=>3),
			array('empresa, cod_fiscal, descricao,obs,categoria', 'length', 'max'=>255),
			array('uom', 'length', 'max'=>5),
			array('destaque,promocao', 'boolean'),

            array('data_update','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, cod_fiscal, descricao, uom, valor', 'safe', 'on'=>'search'),
		);
		
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->required_produto_codfiscal)
			array_push($regras, array('cod_fiscal', 'required'));
		else
			array_push($regras, array('cod_fiscal', 'safe'));
		return $regras;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				//'grupohasprodutos' => array(self::MANY_MANY, 'ErpnetGrupoProduto', 'erpnet_grupo_has_produto(nome, id_produto)'),
				'erpnetGrupoProdutos' => array(self::MANY_MANY, 'ErpnetGrupoProduto', 'erpnet_grupo_has_produto(id_produto, id_grupo_produto)'),
				'erpnetOrdems' => array(self::HAS_MANY, 'ErpnetOrdem', 'id_produto'),
				'erpnetOrdemItems' => array(self::HAS_MANY, 'ErpnetOrdemItem', 'id_produto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Helpers::t('erpnetTables', 'produtoId'),
			//'empresa' => 'Empresa',
			'cod_fiscal' => Helpers::t('erpnetTables', 'produtoNcmNbs'),
			'descricao' => Helpers::t('erpnetTables', 'produtoDescricao'),
			'uom' => Helpers::t('erpnetTables', 'produtoUom'),
			'cod_barra' => Helpers::t('erpnetTables', 'produtoCodBarra'),
			'fabricante' => Helpers::t('erpnetTables', 'produtoFabricante'),
			'estoque_minimo' => Helpers::t('erpnetTables', 'produtoEstoqueMinimo'),
			'moeda' => Helpers::t('erpnetTables', 'produtoMoeda'),
			'valor' => Helpers::t('erpnetTables', 'produtoValor'),
			'erpnetGrupoProdutos' => Helpers::t('erpnetTables', 'produtoGrupo'),
			'obs' => Helpers::t('erpnetTables', 'produtoObs'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		if(!Yii::app()->user->checkAccess('admin')) $criteria->compare('empresa',Yii::app()->user->empresa);
		//$criteria->compare('ativado',1);

		$criteria->compare('id',$this->id);
		//$criteria->compare('empresa',$this->empresa,true);
		$criteria->compare('cod_fiscal',$this->cod_fiscal,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('uom',$this->uom,true);
		$criteria->compare('valor',$this->valor,true);
		//$criteria->order='id';
 
		$datap = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		//$datap->setPagination(false);
		return $datap;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetProduto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getItens(){
		//Estou supondo que exista os campos id e nome_subcategoria na tabela subcategorias, caso n�o seja voc� deve trocar
		if(Yii::app()->user->checkAccess('admin'))
			return CHtml::listData(self::model()->findAll(), 'id', 'concatened');
		else
			return CHtml::listData(self::model()->findAllByAttributes(array('empresa'=>Yii::app()->user->empresa,'ativado'=>1)), 'id', 'concatened');
	
	}
	public static function getItens2(){
		//Estou supondo que exista os campos id e nome_subcategoria na tabela subcategorias, caso n�o seja voc� deve trocar
		if(Yii::app()->user->checkAccess('admin'))
			$models=self::model()->findAll();
		else {
			$criteria=new CDbCriteria;
			$criteria->compare('empresa',Yii::app()->user->empresa);
			$criteria->compare('ativado',1);
			$models=self::model()->findAll($criteria);
		}
		$valores=array();
		foreach($models as $model)
			array_push($valores,CHtml::value($model,'concatened2'));
		return $valores;
		//return CHtml::listData(self::model()->findAll('empresa=:empresa', array(':empresa'=>Yii::app()->user->empresa)), 'concatened');
	
	}
	
	public function getConcatened()
	{
		return $this->descricao.'('.Yii::app()->params['unidades'][$this->uom].')';
	}
	public function getConcatened2()
	{
		return $this->id.': '.$this->descricao.'('.Yii::app()->params['unidades'][$this->uom].')';
	}
	
	public static function getItens3(){
		//Estou supondo que exista os campos id e nome_subcategoria na tabela subcategorias, caso n�o seja voc� deve trocar
		if(Yii::app()->user->checkAccess('admin'))
			$models=self::model()->findAll();
		else {
			$criteria=new CDbCriteria;
			$criteria->compare('empresa',Yii::app()->user->empresa);
			$criteria->compare('ativado',1);
			$models=self::model()->findAll($criteria);
		}
		$valores=array();
		foreach($models as $model)
			array_push($valores,CHtml::value($model,'descricao'));
		return $valores;
		//return CHtml::listData(self::model()->findAll('empresa=:empresa', array(':empresa'=>Yii::app()->user->empresa)), 'concatened');
	
	}
	public static function getIdSearch($string) {
		return self::model()->findByAttributes(array('empresa'=>Yii::app()->user->empresa,'descricao'=>$string))->id;
	}
	public function beforeValidate() {
		//$this->data_entrega = date('Y-m-d', CDateTimeParser::parse($this->data_entrega, Yii::app()->locale->dateFormat));
		if (strpos($this->valor, ','))
			$this->valor = str_replace(',', '.', $this->valor);
		return parent::beforeValidate();
	}

	/**
	 * @return CActiveRecord[]
     */
	public static function getDestaque(){
		return self::model()->findAllByAttributes(array('empresa'=>'ilhanet','ativado'=>1,'destaque'=>1));
	}

	/**
	 * @return CActiveRecord[]
	 * @throws CException
     */
	public static function getProdutos($destaque=false,$empresa='ilhanet'){
		//Yii::import('application.modules.erpnet.models.ErpnetGrupoProduto');
		//Yii::import('application.modules.erpnet.models.ErpnetGrupoHasProduto');

		//$this->dbConnection->queryCachingDuration=60*5;
		//$this->dbConnection->queryCachingCount=50;
		//$this->dbConnection->queryCachingDependency=new CDbCacheDependency('SELECT MAX(data_update) FROM '.$this->tableName());
/*
		if (isset(Yii::app()->user->empresa)) $empresa=Yii::app()->user->empresa;
		$idGrupo=ErpnetGrupoProduto::model()->findByAttributes(array('empresa'=>$empresa,'nome'=>'Delivery'))->id;
		$produtos=ErpnetGrupoHasProduto::model()->findAllByAttributes(array('id_grupo_produto'=>$idGrupo));
		
		$criteria=new CDbCriteria;
		//$criteria->compare('empresa',Yii::app()->user->empresa);
		//$criteria->compare('ativado',1);
		foreach ($produtos as $key=>$produto) {
			$criteria->compare('id',$produto->id_produto,false,'OR');
		}
		if ($destaque) $criteria->compare('destaque',1);
		$criteria->compare('ativado',1);
		//$criteria->order='descricao';
		//die ('<pre>'.CVarDumper::dumpAsString($criteria).'</pre>');
		return self::model()->findAll($criteria);
//*/

		$data= new DbAccess();
		return $data->getErpnetProdutos();

	}

	/**
	 * @param $produto
	 * @return bool
	 */
	public static function temEstoque($produto,$empresa='ilhanet'){

		return ( (self::saldoEstoque($produto,$empresa)>0) ? true:false);
	}

	/**
	 * @param $produto
	 * @return int
     */
	public static function saldoEstoque($produto,$empresa='ilhanet'){
		if (Yii::app()->params['zeraSaldo']) return 0;

		$saldo=0;
		if (isset(Yii::app()->user->empresa)) $empresa=Yii::app()->user->empresa;

		//else{
			$data= new DbAccess();
			//$data=$data->getErpnetEstoque($produto);
			//Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($produto).'</pre>'),'teste');
			//foreach (ErpnetEstoque::model()->findAllByAttributes(array('empresa'=>$empresa,'id_produto'=>$produto)) as $movimentoEstoque){
			$arr=$data->getErpnetEstoque($produto);
			if (is_array($arr)) foreach ($arr as $movimentoEstoque){
				//Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($movimentoEstoque).'</pre>'),'teste');
				$saldo=$saldo+$movimentoEstoque->quantidade;
			}
		//}

        //Zera saldo do Gelo
        if ( ($produto==354)||($produto==355) ) {
            if ( (date('G')>8) && (date('G')<18) ) $saldo=$saldo+2;

        //Controla saldo das Porçoes
        }elseif ( ($produto==378)||($produto==379)||($produto==380) ) {
            $saldo=$saldo+3;
        }

		return $saldo;
	}
	public static function lastCategoria($categoria){
		return substr($categoria, strrpos($categoria,'>')+1,strlen($categoria));
	}

}
