<?php

/**
 * This is the model class for table "erpnet_questionario".
 *
 * The followings are the available columns in table 'erpnet_questionario':
 * @property integer $id
 * @property string $empresa
 * @property string $campo01
 * @property string $campo02
 * @property string $campo03
 * @property string $campo04
 * @property string $campo05
 * @property string $campo06
 * @property string $campo07
 * @property string $campo08
 * @property string $campo09
 * @property string $campo10
 * @property string $campo11
 * @property string $campo12
 * @property string $campo13
 * @property string $campo14
 * @property string $campo15
 */
class ErpnetQuestionario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_questionario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empresa', 'required'),
			array('empresa, campo01, campo02, campo03, campo04, campo05, campo06, campo07, campo08, campo09, campo10, campo11, campo12, campo13, campo14, campo15', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, campo01, campo02, campo03, campo04, campo05, campo06, campo07, campo08, campo09, campo10, campo11, campo12, campo13, campo14, campo15', 'safe', 'on'=>'search'),
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
			'campo01' => '01-Nome da Empresa',
			'campo02' => '02-Nome do entrevistado',
			'campo03' => '03-Contatos',
			'campo04' => utf8_encode('04-Endereço'),
			'campo05' => utf8_encode('05-A empresa possui sistema para controlar as áreas?'),
			'campo06' => utf8_encode('06-Quem decide sobre a aquisição ou modificação de um sistema?'),
			'campo07' => '07-Qual Sistema?',
			'campo08' => '08-Quais as funcionalidades?',
			'campo09' => '09-Qual o investimento?',
			'campo10' => utf8_encode('10-Qual a tarefa mais trabalhosa? Como ela é controlada?'),
			'campo11' => '11-Gostaria de adquirir algum?',
			'campo12' => utf8_encode('12-Qual o investimento disponível?'),
			'campo13' => '13-Qual o porte da empresa?',
			'campo14' => '14-Quantas filiais?',
			'campo15' => utf8_encode('15-Quantos funcionários?'),
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
		$criteria->compare('campo01',$this->campo01,true);
		$criteria->compare('campo02',$this->campo02,true);
		$criteria->compare('campo03',$this->campo03,true);
		$criteria->compare('campo04',$this->campo04,true);
		$criteria->compare('campo05',$this->campo05,true);
		$criteria->compare('campo06',$this->campo06,true);
		$criteria->compare('campo07',$this->campo07,true);
		$criteria->compare('campo08',$this->campo08,true);
		$criteria->compare('campo09',$this->campo09,true);
		$criteria->compare('campo10',$this->campo10,true);
		$criteria->compare('campo11',$this->campo11,true);
		$criteria->compare('campo12',$this->campo12,true);
		$criteria->compare('campo13',$this->campo13,true);
		$criteria->compare('campo14',$this->campo14,true);
		$criteria->compare('campo15',$this->campo15,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetQuestionario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
