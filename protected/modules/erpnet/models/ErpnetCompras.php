<?php

/**
 * This is the model class for table "erpnet_compras".
 *
 * The followings are the available columns in table 'erpnet_compras':
 * @property integer $id
 * @property string $empresa
 * @property string $num_ordem
 * @property string $data_criacao
 * @property string $data_emissao
 * @property string $moeda
 * @property double $conversao_brl
 * @property string $incoterm
 * @property string $incoterm_local
 * @property string $texto
 */
class ErpnetCompras extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_compras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empresa, num_ordem, data_emissao, moeda, conversao_brl', 'required'),
			array('conversao_brl', 'numerical'),
			array('empresa, num_ordem, incoterm_local', 'length', 'max'=>255),
			array('moeda, incoterm', 'length', 'max'=>3),
			array('texto', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, num_ordem, data_criacao, data_emissao, moeda, conversao_brl, incoterm, incoterm_local, texto', 'safe', 'on'=>'search'),
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
			'num_ordem' => 'Num Ordem',
			'data_criacao' => 'Data Criacao',
			'data_emissao' => 'Data Emissao',
			'moeda' => 'Moeda',
			'conversao_brl' => 'Taxa',
			'incoterm' => 'Incoterm',
			'incoterm_local' => 'Incoterm Local',
			'texto' => 'Texto',
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
		$criteria->compare('num_ordem',$this->num_ordem,true);
		$criteria->compare('data_criacao',$this->data_criacao,true);
		$criteria->compare('data_emissao',$this->data_emissao,true);
		$criteria->compare('moeda',$this->moeda,true);
		$criteria->compare('conversao_brl',$this->conversao_brl);
		$criteria->compare('incoterm',$this->incoterm,true);
		$criteria->compare('incoterm_local',$this->incoterm_local,true);
		$criteria->compare('texto',$this->texto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetCompras the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
		$this->data_emissao = date('Y-m-d', CDateTimeParser::parse($this->data_emissao, Yii::app()->locale->dateFormat));
		return true;
	}
}
