<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 *
 * The followings are the available model relations:
 * @property Authitem[] $authitems
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, empresa', 'required', 'on'=>'create,update'),
			array('username', 'required', 'on'=>'create'),
			array('social_identifier,provider, email, empresa', 'required', 'on'=>'createDelivery'),
			array('social_identifier', 'unique', 'on'=>'createDelivery'),
			array('id_cliente,username', 'safe', 'on'=>'createDelivery'),
				
			array('password', 'required', 'on'=>'trocarSenha,create'),
			array('username', 'unique', 'on'=>'create,update'),
				
			array('email', 'email', 'on'=>'createDelivery,create,update'),
			array('username', 'length', 'max'=>64, 'on'=>'create,update'),
			array('password, email', 'length', 'max'=>128, 'on'=>'create'),
			array('trocar_senha, bloqueado', 'boolean'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email', 'safe', 'on'=>'search'),
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
			'authitems' => array(self::MANY_MANY, 'Authitem', 'authassignment(userid, itemname)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => utf8_encode(Yii::t('tables', 'userUsername', array(), 'i18n')),
			'password' => utf8_encode(Yii::t('tables', 'userPassword', array(), 'i18n')),
			'email' => utf8_encode(Yii::t('tables', 'userEmail', array(), 'i18n')),
			//'empresa' => 'Empresa',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		//$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('empresa',$this->empresa,true);
		
		$datap = new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
		$datap->setPagination(false);
		return $datap;
	}

	public function beforeSave() {
		if ( ($this->getScenario()=='create')||($this->getScenario()=='trocarSenha') )
			$this->password = md5($this->password);
		return true;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function init()
	{
		if($this->getScenario()=='createDelivery') {
			if ( (isset(Yii::app()->user->dados))&&(Yii::app()->user->dados!==null) ) {
				$this->provider=Yii::app()->user->dados['provider'];
				$this->social_identifier=Yii::app()->user->dados['identifier'];
				$this->email=Yii::app()->user->dados['email'];
			}
		}
	}	
}
