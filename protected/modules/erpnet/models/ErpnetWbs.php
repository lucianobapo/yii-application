<?php

/**
 * This is the model class for table "erpnet_wbs".
 *
 * The followings are the available columns in table 'erpnet_wbs':
 * @property integer $id
 * @property string $empresa
 * @property integer $id_pai
 * @property string $numero
 * @property string $descricao
 * @property string $tipo
 */
class ErpnetWbs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_wbs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numero, descricao, tipo', 'required'),
			array('id_pai', 'numerical', 'integerOnly'=>true),
			array('empresa, numero, descricao', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, id_pai, numero, descricao, tipo', 'safe', 'on'=>'search'),
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
			'id' => utf8_encode(Yii::t('erpnetTables', 'wbsId', array(), 'i18n')),
			//'empresa' => 'Empresa',
			'id_pai' => utf8_encode(Yii::t('erpnetTables', 'wbsIdPai', array(), 'i18n')),
			'numero' => utf8_encode(Yii::t('erpnetTables', 'wbsNumero', array(), 'i18n')),
			'descricao' => utf8_encode(Yii::t('erpnetTables', 'wbsDescricao', array(), 'i18n')),
			'tipo' => utf8_encode(Yii::t('erpnetTables', 'wbsTipo', array(), 'i18n')),
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
		$criteria->compare('id_pai',$this->id_pai);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('tipo',$this->tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetWbs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getItens($filtro=false,$tipo=''){
		//Estou supondo que exista os campos id e nome_subcategoria na tabela subcategorias, caso não seja você deve trocar
		if(Yii::app()->user->checkAccess('admin'))
			return CHtml::listData(self::model()->findAll(), 'id', 'concatened');
		else {
			$criteria=new CDbCriteria;
			$criteria->compare('empresa',Yii::app()->user->empresa);
			$criteria->order='id_pai';
			if ($filtro) $criteria->compare('tipo',$tipo);
			return CHtml::listData(self::model()->findAll($criteria), 'id', 'concatened');
		}
	}
	
	public static function getItens2($filtro=false,$tipo=''){
		//Estou supondo que exista os campos id e nome_subcategoria na tabela subcategorias, caso não seja você deve trocar
		if(Yii::app()->user->checkAccess('admin'))
			$models=self::model()->findAll();
		else {
			$criteria=new CDbCriteria;
			$criteria->compare('empresa',Yii::app()->user->empresa);
			$criteria->order='id_pai';
			if ($filtro) $criteria->compare('tipo',$tipo);
			$models=self::model()->findAll($criteria);
		}
		$valores=array();
		foreach($models as $model)
			array_push($valores,CHtml::value($model,'concatened'));
		return $valores;//CHtml::listData(self::model()->findAll($criteria), 'concatened');
	}
	
	public function getConcatened()
	{
		if ($this->id_pai>0) {
			$pai=self::model()->findByPk($this->id_pai);
			return $this->id.':'.$pai->numero.'-'.$this->numero.'-'.$this->descricao;
		} else return $this->numero.'-'.$this->descricao;
		
	}
}
