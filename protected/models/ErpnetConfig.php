<?php

/**
 * This is the model class for table "erpnet_config".
 *
 * The followings are the available columns in table 'erpnet_config':
 * @property string $empresa
 * @property integer $mostra_lang
 */
class ErpnetConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_config';
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
			array('mostra_lang,mostra_vendas,mostra_compras,mostra_servico', 'boolean'),
			array('ordem_venda_fechada,ordem_compra_fechada,ordem_servico_fechada', 'boolean'),
			array('movimenta_estoque,movimenta_conta_receber,movimenta_conta_pagar', 'boolean'),
			array('search_produto_venda,search_cliente_venda', 'boolean'),
			array('required_cliente_cnpj,required_produto_codfiscal', 'boolean'),
			array('outras_moedas,cadastra_cliente_venda', 'boolean'),
			array('empresa', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('empresa, mostra_lang', 'safe', 'on'=>'search'),
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
			//'empresa' => 'Empresa',
			'mostra_lang' => Helpers::t('erpnetTables', 'configMostraLang'),
			'mostra_vendas' => Helpers::t('erpnetTables', 'configMostraVendas'),
			'mostra_compras' => Helpers::t('erpnetTables', 'configMostraCompras'),
			'mostra_servico' => Helpers::t('erpnetTables', 'configMostraServico'),
			'movimenta_estoque' => Helpers::t('erpnetTables', 'configMovimentaEstoque'),
			'movimenta_conta_receber' => Helpers::t('erpnetTables', 'configMovimentaContaReceber'),	
			'movimenta_conta_pagar' => Helpers::t('erpnetTables', 'configMovimentaContaPagar'),
			'ordem_venda_fechada' => Helpers::t('erpnetTables', 'configOrdemVendaFechada'),
			'ordem_compra_fechada' => Helpers::t('erpnetTables', 'configOrdemCompraFechada'),
			'ordem_servico_fechada' => Helpers::t('erpnetTables', 'configOrdemServicoFechada'),
			'search_produto_venda' => Helpers::t('erpnetTables', 'configSearchProdutoVenda'),
			'search_cliente_venda' => Helpers::t('erpnetTables', 'configSearchClienteVenda'),
			'required_cliente_cnpj' => Helpers::t('erpnetTables', 'configRequiredClienteCnpj'),
			'required_produto_codfiscal' => Helpers::t('erpnetTables', 'configRequiredProdutoCodfiscal'),
			'outras_moedas' => Helpers::t('erpnetTables', 'configOutrasMoedas'),
			'cadastra_cliente_venda' => Helpers::t('erpnetTables', 'configCadastraCliente'),
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

		$criteria->compare('empresa',$this->empresa,true);
		$criteria->compare('mostra_lang',$this->mostra_lang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErpnetConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
