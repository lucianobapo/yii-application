<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
	const ERROR_USERNAME_BLOCKED=3;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	
	private $_id;
	private $socialIdentifier;
	
	/**
	 * Constructor.
	 * @param string $username username
	 * @param string $password password
	 */
	public function __construct($username=null,$password=null,$socialIdentifier=null)
	{
		$this->username=$username;
		$this->password=$password;
		$this->socialIdentifier=$socialIdentifier;
	}
	
	
	public function authenticate($type=null)
	{
		switch(strtolower($type)){
			case 'social': // for social user login - use in HybridauthController.php
				//$record=User::model()->findByAuthSocial($this->username, $this->password);
				$record=User::model()->findByAttributes(array('social_identifier'=>$this->socialIdentifier));
				
				break;
			case 'user':
			default:
				// for normal registered user login - use in your user login controller
				//$user=User::model()->findByAuthUser($this->username, $this->password);
				$record=User::model()->findByAttributes(array('username'=>$this->username));
				break;
		}//end switch
		
		if($record===null){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			$this->errorMessage=Helpers::t('appError', 'usernameInvalid');
		}elseif($record->bloqueado){
			$this->errorCode=self::ERROR_USERNAME_BLOCKED;
			$this->errorMessage=Helpers::t('appError', 'usernameBlocked');
		}elseif( ($type!='social')&&($record->password!==md5($this->password)) ){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
			$this->errorMessage=Helpers::t('appError', 'passwordInvalid');
		}else
		{
			$this->_id=$record->id;
			$this->setState('empresa', $record->empresa);
			$this->setState('social_identifier', $this->socialIdentifier);
			
			Yii::trace('Login de usuário: '.Yii::app()->name."<br>\nUsuário ".$this->username." logado com sucesso em ".date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'],'application.delivery.login');
			
			$msg=("<br>\nUsuário ".$this->username." logado com sucesso em ".date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST']);
			if ($type=='social') {
				Yii::import('application.modules.delivery.models.DeliveryParceiro');
				$parceiro=DeliveryParceiro::model()->findByPk($record->id_cliente);
				$msg=$msg."<br>\nFoto: <img width=100 height=100 src=$parceiro->custom1>";
			}
			$subject='=?UTF-8?B?'.base64_encode('Usuário logado - '.Yii::app()->name).'?=';
			Helpers::sendMail(array('email'=>Yii::app()->params['adminEmail'],'name'=>$this->username),$subject,$msg,$erro);
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode == self::ERROR_NONE;
	}
	
	public function getId()
	{
		return $this->_id;
	}
}