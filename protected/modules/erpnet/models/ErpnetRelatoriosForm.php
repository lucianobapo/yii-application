<?php

/**
 * ErpnetRelatoriosForm class.
 * ErpnetRelatoriosForm is the data structure for keeping
 * Reports form data. It is used by actions of 'ErpnetRelatoriosController'.
 */
class ErpnetRelatoriosForm extends CFormModel
{
	public $data_inicial;
	public $data_final;
	public $tanque;
	public $produto;
	public $detalhe_dia=false;
	public $detalhe_produtor=false;
	public $exportar_excel=false;

	//private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('data_inicial,data_final', 'required'),
			//array('username, password', 'required', 'on'=>'login'),
			//array('username,old_password, new_password, new_password2', 'required', 'on'=>'trocarSenha'),
			// username deve ter entre 3 e 12 caracteres
			//array('username', 'length', 'min'=>3, 'max'=>12, 'on'=>'login'),
			//array('new_password, new_password2', 'length', 'min'=>8, 'on'=>'trocarSenha'),
			// rememberMe needs to be a boolean
			array('detalhe_produtor,detalhe_dia,exportar_excel', 'boolean'),
			array('tanque,produto', 'safe'),
			// password needs to be authenticated
			//array('password', 'authenticate', 'on'=>'login'),
			//array('old_password', 'authenticate', 'on'=>'trocarSenha'),
			// quando estiver no cenário register, password deve ser igual password2
			//array('new_password', 'compare', 'compareAttribute'=>'new_password2','on'=>'trocarSenha'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'data_inicial'=>utf8_encode(Yii::t('erpnetUi', 'viewRelatorioInicio', array(), 'i18n')),
			'data_final' => utf8_encode(Yii::t('erpnetUi', 'viewRelatorioFinal', array(), 'i18n')),
			'tanque' => utf8_encode(Yii::t('erpnetUi', 'viewRelatorioTanque', array(), 'i18n')),
			'detalhe_dia' => utf8_encode(Yii::t('erpnetUi', 'viewRelatorioDetalheDia', array(), 'i18n')),
			'detalhe_produtor' => utf8_encode(Yii::t('erpnetUi', 'viewRelatorioDetalheProdutor', array(), 'i18n')),
			'exportar_excel' => utf8_encode(Yii::t('erpnetUi', 'viewRelatorioExporta', array(), 'i18n')),
		);
	}

	

}
