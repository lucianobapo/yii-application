<?php

/**
 * This is the model class for table "erpnet_wbs_has_parceiro".
 *
 * The followings are the available columns in table 'erpnet_wbs_has_parceiro':
 * @property integer $id_wbs
 * @property integer $id_parceiro
 *
 * The followings are the available model relations:
 * @property ReportCliente $idParceiro
 * @property ErpnetWbs $idWbs
 */
class ErpnetWbsHasParceiro extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_wbs_has_parceiro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_wbs, id_parceiro', 'required'),
			array('id_wbs, id_parceiro', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_wbs, id_parceiro', 'safe', 'on'=>'search'),
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
			'idParceiro' => array(self::BELONGS_TO, 'ReportCliente', 'id_parceiro'),
			'idWbs' => array(self::BELONGS_TO, 'ErpnetWbs', 'id_wbs'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_wbs' => 'Id Wbs',
			'id_parceiro' => 'Id Parceiro',
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

		$criteria->compare('id_wbs',$this->id_wbs);
		$criteria->compare('id_parceiro',$this->id_parceiro);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetWbsHasParceiro the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
