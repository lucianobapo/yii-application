<?php

/**
 * This is the model class for table "erpnet_entrega".
 *
 * The followings are the available columns in table 'erpnet_entrega':
 * @property integer $id
 * @property string $empresa
 * @property string $data_criacao
 * @property string $usuario
 * @property integer $id_ordem
 * @property integer $cep
 * @property string $endereco
 */
class DeliveryEntrega extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_entrega';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empresa, usuario, id_ordem, cep, endereco', 'required'),
			array('id_ordem, cep', 'numerical', 'integerOnly'=>true),
			array('empresa', 'length', 'max'=>20),
			array('usuario', 'length', 'max'=>100),
			array('endereco', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, data_criacao, usuario, id_ordem, cep, endereco', 'safe', 'on'=>'search'),
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
			'data_criacao' => 'Data Criacao',
			'usuario' => 'Usuario',
			'id_ordem' => 'Id Ordem',
			'cep' => 'Cep',
			'endereco' => 'Endereco',
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
		$criteria->compare('data_criacao',$this->data_criacao,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('id_ordem',$this->id_ordem);
		$criteria->compare('cep',$this->cep);
		$criteria->compare('endereco',$this->endereco,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DeliveryEntrega the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getEntrega($id){
		return self::model()->findByAttributes(array('id_ordem'=>$id));
	}
}
