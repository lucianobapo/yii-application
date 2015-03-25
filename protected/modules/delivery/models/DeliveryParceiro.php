<?php

/**
 * This is the model class for table "report_cliente".
 *
 * The followings are the available columns in table 'report_cliente':
 * @property integer $id
 * @property string $empresa
 * @property string $data_criacao
 * @property string $nome
 * @property string $email
 * @property string $cnpj
 * @property string $endereco
 * @property string $cidade
 * @property string $estado
 * @property string $cep
 * @property integer $cod_area
 * @property string $telefone
 * @property string $contato
 * @property string $obs
 * @property integer $tipo_cliente
 * @property integer $tipo_fornecedor
 * @property integer $tipo_associado
 * @property string $aniversario
 * @property string $adesao
 * @property string $desligamento
 * @property string $matricula
 * @property integer $erro_matricula
 * @property string $instituicao
 * @property string $banco
 * @property integer $ativado
 * @property string $custom1
 * @property string $custom2
 * @property string $custom3
 * @property string $custom4
 * @property string $custom5
 * @property string $custom6
 * @property string $custom7
 * @property string $custom8
 *
 * The followings are the available model relations:
 * @property ErpnetWbs[] $erpnetWbs
 * @property ReportBook[] $reportBooks
 * @property ReportConfLocais[] $reportConfLocaises
 * @property User[] $users
 */
class DeliveryParceiro extends CActiveRecord
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
		return array(
			array('empresa', 'required'),
			array('nome,cep,endereco,cnpj,email,cidade,custom3,estado,custom4,aniversario', 'required', 'on'=>'create'),
			array('email', 'email', 'on'=>'create'),
			array('aniversario', 'type', 'type' => 'date', 'message' => Helpers::t('yii','The format of {attribute} is invalid.',array(),null), 'dateFormat' => Yii::app()->locale->getDateFormat('medium'), 'on'=>'create'),
			array('cnpj', 'unique', 'on'=>'create'),
			array('cnpj', 'validacao', 'on'=>'create'),
			array('cep', 'validacao_cep', 'on'=>'create'),
			array('cnpj,cep', 'numerical', 'integerOnly'=>true),
			array('cod_area, tipo_cliente, tipo_fornecedor, tipo_associado, erro_matricula, ativado', 'numerical', 'integerOnly'=>true),
			array('empresa, cnpj, cep', 'length', 'max'=>20),
			array('nome, email, endereco, telefone, contato, obs, aniversario, adesao, desligamento, matricula', 'length', 'max'=>255),
			array('cidade, instituicao, banco', 'length', 'max'=>30),
			array('estado', 'length', 'max'=>5),
			array('custom1, custom2, custom3, custom4, custom5, custom6, custom7, custom8', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, data_criacao, nome, email, cnpj, endereco, cidade, estado, cep, cod_area, telefone, contato, obs, tipo_cliente, tipo_fornecedor, tipo_associado, aniversario, adesao, desligamento, matricula, erro_matricula, instituicao, banco, ativado, custom1, custom2, custom3, custom4, custom5, custom6, custom7, custom8', 'safe', 'on'=>'search'),
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
			'erpnetWbs' => array(self::MANY_MANY, 'ErpnetWbs', 'erpnet_wbs_has_parceiro(id_parceiro, id_wbs)'),
			'reportBooks' => array(self::HAS_MANY, 'ReportBook', 'id_cliente'),
			'reportConfLocaises' => array(self::HAS_MANY, 'ReportConfLocais', 'id_cliente'),
			'users' => array(self::HAS_MANY, 'User', 'id_cliente'),
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
			'nome' => Helpers::t('erpnetTables', 'clienteNome'),
			'email' => 'Email',
			'cnpj' => Helpers::t('erpnetTables', 'clienteCnpjCpf'),
			'endereco' => Helpers::t('erpnetTables', 'Logradouro'),
			'cidade' => Helpers::t('erpnetTables', 'Cidade'),
			'estado' => Helpers::t('erpnetTables', 'UF'),
			'cep' => 'CEP',
			'cod_area' => 'Cod Area',
			'telefone' => Helpers::t('erpnetTables', 'clienteTelefone'),
			'contato' => 'Contato',
			'obs' => 'Obs',
			'tipo_cliente' => 'Tipo Cliente',
			'tipo_fornecedor' => 'Tipo Fornecedor',
			'tipo_associado' => 'Tipo Associado',
			'aniversario' => Helpers::t('erpnetTables', 'Data de Nascimento'),
			'adesao' => 'Adesao',
			'desligamento' => 'Desligamento',
			'matricula' => 'Matricula',
			'erro_matricula' => 'Erro Matricula',
			'instituicao' => 'Instituicao',
			'banco' => 'Banco',
			'ativado' => 'Ativado',
			'custom1' => 'Custom1',
			'custom2' => 'Custom2',
			'custom3' => Helpers::t('erpnetTables', 'Bairro'),
			'custom4' => Helpers::t('erpnetTables', 'Número / Compl.'),
			'custom5' => 'Custom5',
			'custom6' => 'Custom6',
			'custom7' => 'Custom7',
			'custom8' => 'Custom8',
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('endereco',$this->endereco,true);
		$criteria->compare('cidade',$this->cidade,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('cod_area',$this->cod_area);
		$criteria->compare('telefone',$this->telefone,true);
		$criteria->compare('contato',$this->contato,true);
		$criteria->compare('obs',$this->obs,true);
		$criteria->compare('tipo_cliente',$this->tipo_cliente);
		$criteria->compare('tipo_fornecedor',$this->tipo_fornecedor);
		$criteria->compare('tipo_associado',$this->tipo_associado);
		$criteria->compare('aniversario',$this->aniversario,true);
		$criteria->compare('adesao',$this->adesao,true);
		$criteria->compare('desligamento',$this->desligamento,true);
		$criteria->compare('matricula',$this->matricula,true);
		$criteria->compare('erro_matricula',$this->erro_matricula);
		$criteria->compare('instituicao',$this->instituicao,true);
		$criteria->compare('banco',$this->banco,true);
		$criteria->compare('ativado',$this->ativado);
		$criteria->compare('custom1',$this->custom1,true);
		$criteria->compare('custom2',$this->custom2,true);
		$criteria->compare('custom3',$this->custom3,true);
		$criteria->compare('custom4',$this->custom4,true);
		$criteria->compare('custom5',$this->custom5,true);
		$criteria->compare('custom6',$this->custom6,true);
		$criteria->compare('custom7',$this->custom7,true);
		$criteria->compare('custom8',$this->custom8,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DeliveryParceiro the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function validacao($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			if (!Helpers::valida_cpf($this->cnpj) && !Helpers::valida_cnpj($this->cnpj))
				$this->addError($attribute,Helpers::t('appUi','CPF/CNPJ "{cnpj}" Inválido',array('{cnpj}'=>$this->cnpj)));
		}
	}
	public function validacao_cep($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->cep=(integer)$this->cep;
			if (($this->cep<28890001) || ($this->cep>28899999))
				$this->addError($attribute,Helpers::t('appUi',"CEP {cep} fora da Faixa de 28890-001 a 28899-999. Podemos entregar somente em Rio das Ostras/RJ.",array('{cep}'=>$this->cep)));
		}
	}
	
	public function init()
	{
		if($this->getScenario()=='create') {
			if ( (isset(Yii::app()->user->dados))&&(Yii::app()->user->dados!==null) ) {
				$this->nome=Yii::app()->user->dados['displayName'];
				$this->email=Yii::app()->user->dados['email'];
				$this->custom1=Yii::app()->user->dados['photoURL'];
				if ( (Yii::app()->user->dados['birthDay']!==null)&&(Yii::app()->user->dados['birthMonth']!==null)&&(Yii::app()->user->dados['birthYear']!==null) ) {
					$time=mktime(null,null,null,Yii::app()->user->dados['birthMonth'],Yii::app()->user->dados['birthDay'],Yii::app()->user->dados['birthYear']);
					$this->aniversario=Yii::app()->dateFormatter->formatDateTime($time,'medium',null);
				}
			}			
		}
	}

	/**
	 *
     */
	public function afterValidate() {
		if ($this->hasErrors()) {
			Helpers::registraErro($this->getErrors());
		} else {
			//Converte data de aniversário para timestamp
			$this->aniversario = CDateTimeParser::parse($this->aniversario, Yii::app()->locale->getDateFormat('medium'));
		}
		parent::afterValidate();
	}
}
