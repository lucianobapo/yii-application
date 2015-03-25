<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $new_password;
	public $new_password2;
	public $old_password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username', 'required'),
			array('username, password', 'required', 'on'=>'login'),
			array('username,old_password, new_password, new_password2', 'required', 'on'=>'trocarSenha'),
			// username deve ter entre 3 e 12 caracteres
			array('username', 'length', 'min'=>3, 'max'=>12, 'on'=>'login'),
			array('new_password, new_password2', 'length', 'min'=>8, 'on'=>'trocarSenha'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean', 'on'=>'login'),
			// password needs to be authenticated
			array('password', 'authenticate', 'on'=>'login'),
			array('old_password', 'authenticate', 'on'=>'trocarSenha'),
			// quando estiver no cenário register, password deve ser igual password2
			array('new_password', 'compare', 'compareAttribute'=>'new_password2','on'=>'trocarSenha'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>utf8_encode(Yii::t('app', 'appFormLabel2', array(), 'i18n')),
			'username' => utf8_encode(Yii::t('tables', 'userUsername', array(), 'i18n')),
			'password' => utf8_encode(Yii::t('tables', 'userPassword', array(), 'i18n')),
			'new_password' => utf8_encode(Yii::t('erpnetUi', 'viewTrocaSenhaNewPass', array(), 'i18n')),
			'new_password2' => utf8_encode(Yii::t('erpnetUi', 'viewTrocaSenhaNewPass2', array(), 'i18n')),
			'old_password' => utf8_encode(Yii::t('erpnetUi', 'viewTrocaSenhaOldPass', array(), 'i18n')),
			//'email' => utf8_encode(Yii::t('tables', 'userEmail', array(), 'i18n')),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->$attribute);
			if(!$this->_identity->authenticate())
				$this->addError($attribute,$this->_identity->errorMessage);
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

}
