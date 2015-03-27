<?php

/**
 * This is the model class for table "erpnet_ordem".
 *
 * The followings are the available columns in table 'erpnet_ordem':
 * @property integer $id
 * @property string $empresa
 * @property string $data_criacao
 * @property string $data_termino
 * @property integer $id_produto
 * @property integer $id_wbs
 * @property string $turno
 * @property double $quantidade
 *
 * The followings are the available model relations:
 * @property ErpnetWbs $idWbs
 * @property ErpnetProduto $idProduto
 */
class ErpnetOrdem extends CActiveRecord
{	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_ordem';

	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('data_termino, turno, id_produto', 'required', 'on'=>'producao'),
			array('data_termino, turno, id_produto, id_wbs', 'required', 'on'=>'producaoMassa'),
				
			array('data_termino, id_cliente', 'required', 'on'=>'venda,servico,compra'),

			array('pagamento', 'required', 'on'=>'venda'),

			array('data_termino, id_wbs_destino,id_wbs', 'required', 'on'=>'consumo'),
			//array('data_termino, turno, quantidade', 'safe'),
			//array('data_inicio,texto_header', 'required', 'on'=>'servico'),
			array('empresa, tipo, usuario', 'required'),
			array('status_fechado,status_cancelado', 'boolean'),
			array('pagamento, referencia, obs, status_fechado', 'safe'),
			array('id_cliente, id_produto, id_wbs', 'numerical', 'integerOnly'=>true),
			array('quantidade, troco, desconto', 'numerical'),
				
			array('valor', 'numerical'),
			//array('valor', 'match', 'pattern'=>'/^\d*[,]\d{2}$/','message' => 'Dever� no formato 99,99'),
					
			array('empresa', 'length', 'max'=>255),

            //array('data_criacao', 'required','on'=>'insert,venda'),
            array('data_criacao,data_update','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert,venda'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, data_criacao, data_termino, id_produto, id_wbs, turno, quantidade', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idWbs' => array(self::BELONGS_TO, 'ErpnetWbs', 'id_wbs'),
			'idProduto' => array(self::BELONGS_TO, 'ErpnetProduto', 'id_produto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels=array(
			'id' => Helpers::t('erpnetTables', 'ordemId'),
			//'empresa' => 'Empresa',
			//'data_criacao' => 'Data Criacao',
			'data_termino' => Helpers::t('erpnetTables', 'ordemData'),
			'id_produto' => Helpers::t('erpnetTables', 'ordemProduto'),
			'id_wbs' => Helpers::t('erpnetTables', 'ordemWbs'),
			'id_cliente' => Helpers::t('erpnetTables', 'ordemCliente'),
			'turno' => Helpers::t('erpnetTables', 'ordemTurno'),
			'quantidade' => Helpers::t('erpnetTables', 'ordemQuantidade'),
			'valor' => Helpers::t('erpnetTables', 'ordemValor'),
			'moeda' => Helpers::t('erpnetTables', 'ordemMoeda'),
			'status_fechado' => Helpers::t('erpnetTables', 'ordemStatusFechado'),
			'obs' => Helpers::t('erpnetTables', 'ordemObs'),
		);
		if ($this->getScenario()=='compra') {
			$labels['id_cliente'] = Helpers::t('erpnetTables', 'ordemFornecedor');
			$labels['data_termino'] = Helpers::t('erpnetTables', 'ordemDataCompra');
		}
		if ($this->getScenario()=='consumo') {
			$labels['id_wbs'] = Helpers::t('erpnetTables', 'ordemWbsOrigem');
			$labels['id_wbs_destino'] = Helpers::t('erpnetTables', 'ordemWbsDestino');
		}
		return $labels;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('empresa',$this->empresa,true);
		$criteria->compare('data_criacao',$this->data_criacao,true);
		$criteria->compare('data_termino',$this->data_termino,true);
		$criteria->compare('id_produto',$this->id_produto);
		$criteria->compare('id_wbs',$this->id_wbs);
		$criteria->compare('turno',$this->turno,true);
		$criteria->compare('quantidade',$this->quantidade);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetOrdem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
		if($this->getScenario()=='venda') {
			//$this->data_termino = CDateTimeParser::parse($this->data_termino, Yii::app()->locale->dateFormat);
			//$this->data_termino = CDateTimeParser::parse($this->data_termino, 'dd/MM/yyyy');
		}
		if($this->getScenario()=='compra') {
			//$this->data_termino = CDateTimeParser::parse($this->data_termino, Yii::app()->locale->dateFormat);
		}
		if($this->getScenario()=='servico') {
			//$this->data_termino = CDateTimeParser::parse($this->data_termino, Yii::app()->locale->dateFormat);
		}
		if($this->getScenario()=='producaoMassa') {
			//$this->data_termino = date('Y-m-d',CDateTimeParser::parse($this->data_termino, Yii::app()->locale->dateFormat));
		}
		//$this->data_termino = CDateTimeParser::parse($this->data_termino, Yii::app()->locale->dateFormat);
		return parent::beforeSave();
	}
	
	public function afterValidate() {
		if ($this->hasErrors()) {
			Helpers::registraErro($this->getErrors());
			//converte troco para original
			if (strpos($this->troco, '.')) $this->troco = str_replace('.', ',', $this->troco);
		}

		parent::afterValidate();
	}

	public function beforeValidate(){
		$this->usuario=(isset(Yii::app()->user->social_identifier)? Yii::app()->user->social_identifier:Yii::app()->user->name);
		$this->empresa=Yii::app()->user->empresa;

		//converte troco para internacional
		if (strpos($this->troco, ',')) $this->troco = str_replace(',', '.', $this->troco);

		return parent::beforeValidate();
	}

	public function beforeFind() {
		//$this->getDbCriteria();
		//$this->getTableAlias();
		
		//$dependency = new CDbCacheDependency('SELECT MAX(data_update) FROM erpnet_ordem');
		//$authors = Author::model()->cache(1000, $dependency)->with('book')->findAll();
		//CVarDumper::dumpAsString($var);
		//$this->cache(1000, $dependency);
		//$this->cache(1000, $dependency);
/*
		if(Yii::app()->params['queryCache']["$this->id"]['cachingDuration']>0
			&& Yii::app()->params['queryCache']["get_class($this)"]['cacheID']!==false
			&& ($cache=Yii::app()->getComponent(Yii::app()->params['queryCache']["$this->id"]['cacheID']))!==null){
			$key=get_class($this).'.'.$this->tableName().'.beforeFind';
			if(($data=$cache->get($key))!==false) {
				Yii::trace('Servindo dados do cache',$key);
				//retorna os dados do cache
				return unserialize($data);
			}

		}

		$this->dbConnection->queryCachingDuration=60*5;
		$this->dbConnection->queryCachingCount=50;
		$this->dbConnection->queryCachingDependency=new CDbCacheDependency('SELECT MAX(data_update) FROM '.$this->tableName());

		//perform find

		//set cache
		if(isset($cache)) {
			$dependency = new CDbCacheDependency('SELECT MAX(data_update) FROM '.$this->tableName());
			$cache->set($key,serialize($messages),Yii::app()->params['queryCache']["$this->id"]['cachingDuration'],$dependency);
		}
*/
		parent::beforeFind();
	}
	
	public function init()
	{
		if($this->getScenario()=='venda') {
			$this->status_fechado=ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->ordem_venda_fechada;
			$this->data_termino=Yii::app()->dateFormatter->formatDateTime(strtotime("now"),'medium',null);

			//$this->dbConnection->queryCachingDuration=60*5;
			//$this->dbConnection->queryCachingCount=50;
			//$this->dbConnection->queryCachingDependency=new CDbCacheDependency('SELECT MAX(data_update) FROM '.$this->tableName());
		}
		if($this->getScenario()=='compra') {
			$this->data_termino=Yii::app()->dateFormatter->formatDateTime(strtotime("now"),'medium',null);
			$this->status_fechado=ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->ordem_compra_fechada;
		}
		if($this->getScenario()=='servico') {
			$this->data_termino=Yii::app()->dateFormatter->formatDateTime(strtotime("now"),'medium',null);
			$this->status_fechado=ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->ordem_servico_fechada;
		}
	}
}
