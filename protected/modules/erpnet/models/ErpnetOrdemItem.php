<?php

/**
 * This is the model class for table "erpnet_ordem_item".
 *
 * The followings are the available columns in table 'erpnet_ordem_item':
 * @property integer $id
 * @property string $empresa
 * @property string $data_criacao
 * @property string $usuario
 * @property string $data_inicio
 * @property string $data_termino
 * @property integer $id_produto
 * @property integer $id_ordem
 * @property string $turno
 * @property double $quantidade
 * @property double $valor
 * @property string $moeda
 * @property string $texto_item
 */
class ErpnetOrdemItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_ordem_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quantidade, empresa, id_produto, id_ordem', 'required'),
			array('data_entrega', 'required', 'on'=>'compra'),
			array('valor', 'required', 'on'=>'consumo'),
			array('id_produto, id_ordem', 'numerical', 'integerOnly'=>true),
			array('quantidade', 'numerical'),
				
			array('valor', 'numerical'),
			//array('valor', 'match', 'pattern'=>'/^\d*[,]\d{2}$/','message' => 'Dever� no formato 99,99'),
				
			array('empresa, usuario', 'length', 'max'=>255),
			array('moeda', 'length', 'max'=>3),
			array('data_inicio, data_termino, turno, texto_item', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, data_criacao, usuario, data_inicio, data_termino, id_produto, id_ordem, turno, quantidade, valor, moeda, texto_item', 'safe', 'on'=>'search'),
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
				'idOrdem' => array(self::BELONGS_TO, 'ErpnetOrdem', 'id_ordem'),
				'idProduto' => array(self::BELONGS_TO, 'ErpnetProduto', 'id_produto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels= array(
			'id' => 'ID',
			'empresa' => 'Empresa',
			'data_criacao' => 'Data Criacao',
			'usuario' => 'Usuario',
			'data_inicio' => 'Data Inicio',
			'id_ordem' => 'Id Ordem',
			'turno' => 'Turno',
			'texto_item' => 'Texto Item',
			'data_termino' => utf8_encode(Yii::t('erpnetTables', 'ordemData', array(), 'i18n')),
			'data_entrega' => utf8_encode(Yii::t('erpnetTables', 'ordemDataEntrega', array(), 'i18n')),
			'id_produto' => utf8_encode(Yii::t('erpnetTables', 'ordemProduto', array(), 'i18n')),
			'quantidade' => utf8_encode(Yii::t('erpnetTables', 'ordemQuantidade', array(), 'i18n')),
			'valor' => utf8_encode(Yii::t('erpnetTables', 'ordemValor', array(), 'i18n')),
			'moeda' => utf8_encode(Yii::t('erpnetTables', 'ordemMoeda', array(), 'i18n')),
		);
		//if ($this->getScenario()=='compra')
			//$labels['valor'] = utf8_encode(Yii::t('erpnetTables', 'ordemValorCompra', array(), 'i18n'));
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
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('data_inicio',$this->data_inicio,true);
		$criteria->compare('data_termino',$this->data_termino,true);
		$criteria->compare('id_produto',$this->id_produto);
		$criteria->compare('id_ordem',$this->id_ordem);
		$criteria->compare('turno',$this->turno,true);
		$criteria->compare('quantidade',$this->quantidade);
		$criteria->compare('valor',$this->valor);
		$criteria->compare('moeda',$this->moeda,true);
		$criteria->compare('texto_item',$this->texto_item,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetOrdemItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
		//$this->data_entrega = date('Y-m-d', CDateTimeParser::parse($this->data_entrega, Yii::app()->locale->dateFormat));
		if($this->getScenario()=='venda') {
			//$this->data_termino = CDateTimeParser::parse($this->data_termino, Yii::app()->locale->dateFormat);
		}
		if($this->getScenario()=='compra') {
			//$this->data_entrega = CDateTimeParser::parse($this->data_termino, Yii::app()->locale->dateFormat);
		}
		if($this->getScenario()=='servico') {
			//$this->data_termino = date('Y-m-d',CDateTimeParser::parse($this->data_termino, Yii::app()->locale->dateFormat));
		}
		if($this->getScenario()=='producaoMassa') {
			//$this->data_termino = date('Y-m-d',CDateTimeParser::parse($this->data_termino, Yii::app()->locale->dateFormat));
		}
		return parent::beforeSave();
	}
	
	public function beforeValidate() {
		$this->usuario=(isset(Yii::app()->user->social_identifier)? Yii::app()->user->social_identifier:Yii::app()->user->name);
		$this->empresa=Yii::app()->user->empresa;

		//converte valor para internacional
		if (strpos($this->valor, ',')) $this->valor = str_replace(',', '.', $this->valor);
		//converte quantidade para internacional
		if (strpos($this->quantidade, ',')) $this->quantidade = str_replace(',', '.', $this->quantidade);
		
		return parent::beforeValidate();
	}
	
	public function afterValidate() {
		if ($this->hasErrors()) {
			Helpers::registraErro($this->getErrors());
			//converte valor para vírgula
			if (strpos($this->valor, '.')) $this->valor = str_replace('.', ',', $this->valor);
			//converte quantidade para vírgula
			if (strpos($this->quantidade, '.')) $this->quantidade = str_replace('.', ',', $this->quantidade);
		}
		return parent::afterValidate();
	}
	
	public function init()
	{
		if($this->getScenario()=='venda') {
			$this->quantidade=1;
			$this->valor=0;
		}
		if($this->getScenario()=='compra') {
			$this->data_entrega=Yii::app()->dateFormatter->formatDateTime(strtotime("now"),'medium',null);
			$this->quantidade=1;
			$this->valor=0;
		}
		if($this->getScenario()=='servico') {
			$this->quantidade=1;
			$this->valor=0;
		}
	
	}
}
