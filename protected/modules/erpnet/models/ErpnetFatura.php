<?php

/**
 * This is the model class for table "erpnet_fatura".
 *
 * The followings are the available columns in table 'erpnet_fatura':
 * @property integer $id
 * @property string $empresa
 * @property integer $id_produto
 * @property integer $id_ordem
 * @property integer $id_wbs
 * @property string $descricao_wbs
 * @property string $data_criacao
 * @property string $data_movimento
 * @property string $usuario
 * @property double $quantidade
 * @property double $valor
 * @property string $moeda
 * @property string $turno
 * @property string $tipo
 */
class ErpnetFatura extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_fatura';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empresa, id_produto, id_wbs, data_movimento, quantidade, tipo', 'required'),
			array('usuario,descricao_wbs, turno, id_ordem', 'safe'),
			array('id_produto, id_ordem, id_wbs', 'numerical', 'integerOnly'=>true),
			array('quantidade, valor', 'numerical'),
			array('empresa, descricao_wbs, usuario, turno', 'length', 'max'=>255),
			array('moeda', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, id_produto, id_ordem, id_wbs, descricao_wbs, data_criacao, data_movimento, usuario, quantidade, valor, moeda, turno, tipo', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'empresa' => 'Empresa',
			'id_produto' => utf8_encode(Yii::t('erpnetTables', 'estoqueIdProduto', array(), 'i18n')),
			'id_ordem' => 'Id Ordem',
			'id_wbs' => utf8_encode(Yii::t('erpnetTables', 'estoqueIdWbs', array(), 'i18n')),
			'descricao_wbs' => 'Descricao Wbs',
			'data_criacao' => 'Data Criacao',
			'data_movimento' => utf8_encode(Yii::t('erpnetTables', 'estoqueDataMovimento', array(), 'i18n')),
			'usuario' => 'Usuario',
			'quantidade' => 'Quantidade',
			'valor' => 'Valor',
			'moeda' => 'Moeda',
			'turno' => 'Turno',
			'tipo' => 'Tipo',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('empresa',$this->empresa,true);
		$criteria->compare('id_produto',$this->id_produto);
		$criteria->compare('id_ordem',$this->id_ordem);
		$criteria->compare('id_wbs',$this->id_wbs);
		$criteria->compare('descricao_wbs',$this->descricao_wbs,true);
		$criteria->compare('data_criacao',$this->data_criacao,true);
		$criteria->compare('data_movimento',$this->data_movimento,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('quantidade',$this->quantidade);
		$criteria->compare('valor',$this->valor);
		$criteria->compare('moeda',$this->moeda,true);
		$criteria->compare('turno',$this->turno,true);
		$criteria->compare('tipo',$this->tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetFatura the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
		//$this->data_movimento = CDateTimeParser::parse($this->data_movimento, Yii::app()->locale->dateFormat);
		$this->descricao_wbs= ErpnetWbs::model()->findByPk($this->id_wbs)->concatened;
		$this->usuario=Yii::app()->user->name;
		return parent::beforeSave();
	}
}
