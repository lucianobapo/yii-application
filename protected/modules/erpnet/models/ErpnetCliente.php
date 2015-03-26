<?php

/**
 * This is the model class for table "report_cliente".
 *
 * The followings are the available columns in table 'report_cliente':
 * @property integer $id
 * @property string $empresa
 * @property string $nome
 * @property string $email
 * @property string $cnpj
 * @property string $endereco
 * @property string $telefone
 * @property integer $contato
 * @property string $obs
 *
 * The followings are the available model relations:
 * @property ReportBook[] $reportBooks
 * @property ReportConfLocais[] $reportConfLocaises
 * @property User[] $users
 */
class ErpnetCliente extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'report_cliente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$regras= array(
			array('empresa, nome', 'required'),
			array('email, endereco, telefone, contato, obs, ativado', 'safe'),
				
			//novos campos
			array('cep, cidade, estado, cod_area, instituicao, banco', 'safe'),
			array('custom1, custom2, custom3, custom4, custom5, custom6, custom7, custom8', 'safe'),
			array('erro_matricula', 'boolean'),
				
				
			//array('contato', 'numerical', 'integerOnly'=>true),
			array('tipo_cliente,tipo_fornecedor', 'boolean'),
			array('empresa, nome, email, cnpj, endereco, telefone, obs', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, nome, email, cnpj, endereco, telefone, contato, obs', 'safe', 'on'=>'search'),
		);
		if (ErpnetConfig::model()->findByPk(Yii::app()->user->empresa)->required_cliente_cnpj)
			array_push($regras, array('cnpj', 'required'));
		else
			array_push($regras, array('cnpj', 'safe'));
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
			//'reportBooks' => array(self::HAS_MANY, 'ReportBook', 'id_cliente'),
			//'reportConfLocaises' => array(self::HAS_MANY, 'ReportConfLocais', 'id_cliente'),
			'users' => array(self::HAS_MANY, 'User', 'id_cliente'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'id' => 'ID',
			//'empresa' => 'Empresa',
			'nome' => utf8_encode(Yii::t('erpnetTables', 'clienteNome', array(), 'i18n')),
			'email' => utf8_encode(Yii::t('erpnetTables', 'clienteEmail', array(), 'i18n')),
			'cnpj' => utf8_encode(Yii::t('erpnetTables', 'clienteCnpjCpf', array(), 'i18n')),
			'endereco' => utf8_encode(Yii::t('erpnetTables', 'clienteEndereco', array(), 'i18n')),
			'telefone' => utf8_encode(Yii::t('erpnetTables', 'clienteTelefone', array(), 'i18n')),
			'contato' => utf8_encode(Yii::t('erpnetTables', 'clienteContato', array(), 'i18n')),
			'obs' => utf8_encode(Yii::t('erpnetTables', 'clienteObs', array(), 'i18n')),
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('endereco',$this->endereco,true);
		$criteria->compare('telefone',$this->telefone,true);
		$criteria->compare('contato',$this->contato);
		$criteria->compare('obs',$this->obs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetCliente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getItens($filtro=false,$tipo=''){
		//Estou supondo que exista os campos id e nome_subcategoria na tabela subcategorias, caso não seja você deve trocar
		if(Yii::app()->user->checkAccess('admin'))
			return CHtml::listData(self::model()->findAll(), 'id', 'nome');
		else {
			$criteria=new CDbCriteria;
			$criteria->compare('empresa',Yii::app()->user->empresa);
			$criteria->compare('ativado',1);
			//$criteria->order='id_pai';
			if ($filtro) $criteria->compare($tipo,1);
			return CHtml::listData(self::model()->findAll($criteria), 'id', 'nome');
		}
	}
	
	public static function getItens3($filtro=false,$tipo=''){
		//Estou supondo que exista os campos id e nome_subcategoria na tabela subcategorias, caso não seja você deve trocar
		if(Yii::app()->user->checkAccess('admin'))
			$models=self::model()->findAll();
		else {
			$criteria=new CDbCriteria;
			$criteria->compare('empresa',Yii::app()->user->empresa);
			$criteria->compare('ativado',1);
			if ($filtro) $criteria->compare($tipo,1);
			$models=self::model()->findAll($criteria);
		}
		$valores=array();
		foreach($models as $model)
			array_push($valores,CHtml::value($model,'nome'));
		return $valores;
	}
	
	public static function getIdSearch($string) {
		return self::model()->findByAttributes(array('empresa'=>Yii::app()->user->empresa,'nome'=>$string))->id;
	}
	
	public function afterValidate() {
		if ($this->hasErrors()) {
			Helpers::registraErro($this->getErrors());
		}
		return parent::afterValidate();
	}
}
