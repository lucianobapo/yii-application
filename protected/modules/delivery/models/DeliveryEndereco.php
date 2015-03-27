<?php

/**
 * This is the model class for table "erpnet_enderecos".
 *
 * The followings are the available columns in table 'erpnet_enderecos':
 * @property integer $id
 * @property integer $empresa
 * @property string $data_criacao
 * @property string $data_update
 * @property integer $id_entidade
 * @property integer $cep
 * @property string $logradouro
 * @property string $bairro
 * @property string $cidade
 * @property string $estado
 * @property string $pais
 * @property string $complemento
 * @property string $obs
 */
class DeliveryEndereco extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_enderecos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empresa, usuario, id_entidade, logradouro, cep, bairro, cidade, estado, complemento', 'required'),
			array('id_entidade, cep', 'numerical', 'integerOnly'=>true),
			array('logradouro, complemento, obs', 'length', 'max'=>255),
			array('bairro, cidade, estado, pais', 'length', 'max'=>50),
			array('data_update, data_criacao, principal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, data_criacao, data_update, id_entidade, cep, logradouro, bairro, cidade, estado, pais, complemento, obs', 'safe', 'on'=>'search'),
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
			'id' => Helpers::t('appTables.DeliveryEndereco','ID'),
			'empresa' => Helpers::t('appTables.DeliveryEndereco','Empresa'),
			'data_criacao' => Helpers::t('appTables.DeliveryEndereco','Data Criacao'),
			'data_update' => Helpers::t('appTables.DeliveryEndereco','Data Update'),
			'id_entidade' => Helpers::t('appTables.DeliveryEndereco','Id Entidade'),
			'cep' => Helpers::t('appTables.DeliveryEndereco','CEP'),
			'logradouro' => Helpers::t('appTables.DeliveryEndereco','Logradouro'),
			'bairro' => Helpers::t('appTables.DeliveryEndereco','Bairro'),
			'cidade' => Helpers::t('appTables.DeliveryEndereco','Cidade'),
			'estado' => Helpers::t('appTables.DeliveryEndereco','Estado'),
			'pais' => Helpers::t('appTables.DeliveryEndereco','Pais'),
			'complemento' => Helpers::t('appTables.DeliveryEndereco','Número / Compl.'),
			'obs' => Helpers::t('appTables.DeliveryEndereco','Observação'),
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
		$criteria->compare('empresa',(isset(Yii::app()->user->empresa)?Yii::app()->user->empresa:'ilhanet'));
        $criteria->compare('usuario',Yii::app()->user->social_identifier);
        $criteria->compare('status_cancelado','0');

		$criteria->compare('cep',$this->cep);
		$criteria->compare('logradouro',$this->logradouro,true);
		$criteria->compare('bairro',$this->bairro,true);
		$criteria->compare('cidade',$this->cidade,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('pais',$this->pais,true);
		$criteria->compare('complemento',$this->complemento,true);
		$criteria->compare('obs',$this->obs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DeliveryEndereco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function afterValidate() {
		if ($this->hasErrors()) {
			Helpers::registraErro($this->getErrors());
		}
		parent::afterValidate();
	}

    public function beforeValidate(){
        if (empty($this->usuario)) $this->usuario=Yii::app()->user->social_identifier;
        $this->empresa=(isset(Yii::app()->user->empresa)?Yii::app()->user->empresa:'ilhanet');
        return parent::beforeValidate();
    }

    public static function isOpen($id){
        $modelCache=new DbAccess();
        //$modelCache->getEndereco($id);
        return (!$modelCache->getEndereco($id)->status_cancelado);
    }

    public static function isPrincipal($id){
        return self::model()->findByPk($id)->principal;
        /*
        $modelCache=new DbAccess();
        //$modelCache->getEndereco($id);
        return ($modelCache->getEndereco($id)->principal);
        */
    }

}
