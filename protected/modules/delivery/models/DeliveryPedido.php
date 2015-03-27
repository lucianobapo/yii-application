<?php

/**
 * This is the model class for table "erpnet_ordem".
 *
 * The followings are the available columns in table 'erpnet_ordem':
 * @property integer $id
 * @property string $empresa
 * @property string $data_criacao
 * @property string $usuario
 * @property string $data_inicio
 * @property string $data_termino
 * @property integer $id_produto
 * @property integer $id_wbs
 * @property integer $id_wbs_destino
 * @property integer $id_cliente
 * @property string $turno
 * @property double $quantidade
 * @property double $valor
 * @property string $moeda
 * @property string $tipo
 * @property string $pagamento
 * @property string $texto_header
 * @property string $referencia
 * @property string $obs
 * @property integer $status_fechado
 *
 * The followings are the available model relations:
 * @property ErpnetProduto $idProduto
 * @property ErpnetOrdemItem[] $erpnetOrdemItems
 */
class DeliveryPedido extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erpnet_ordem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empresa,data_criacao, tipo, pagamento', 'required'),
			array('id_produto, id_wbs, id_wbs_destino, id_cliente, status_fechado', 'numerical', 'integerOnly'=>true),
			array('quantidade, valor', 'numerical'),
			array('empresa, data_termino', 'length', 'max'=>20),
			array('usuario, referencia, obs', 'length', 'max'=>255),
			array('moeda', 'length', 'max'=>3),
			array('data_inicio, turno, pagamento, texto_header', 'safe'),

            array('data_update', 'required','on'=>'update'),
            array('data_criacao', 'required','on'=>'insert,venda'),

            array('data_update','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update'),

            array('data_criacao,data_update','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert,venda'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa, usuario, data_inicio, data_termino, id_produto, id_wbs, id_wbs_destino, id_cliente, turno, quantidade, valor, moeda, tipo, pagamento, texto_header, referencia, obs, status_fechado', 'safe', 'on'=>'search'),
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
			'idProduto' => array(self::BELONGS_TO, 'ErpnetProduto', 'id_produto'),
			'erpnetOrdemItems' => array(self::HAS_MANY, 'ErpnetOrdemItem', 'id_ordem'),
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
			'data_inicio' => 'Data Inicio',
			'data_termino' => 'Data Termino',
			'id_produto' => 'Id Produto',
			'id_wbs' => 'Id Wbs',
			'id_wbs_destino' => 'Id Wbs Destino',
			'id_cliente' => 'Id Cliente',
			'turno' => 'Turno',
			'quantidade' => 'Quantidade',
			'valor' => 'Valor',
			'moeda' => 'Moeda',
			'tipo' => 'Tipo',
			'pagamento' => 'Pagamento',
			'texto_header' => 'Texto Header',
			'referencia' => 'Referencia',
			'obs' => 'Obs',
			'status_fechado' => 'Status Fechado',
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
		
		$criteria->compare('empresa',Yii::app()->user->empresa);
		$criteria->compare('usuario',Yii::app()->user->social_identifier);

		$criteria->compare('id',$this->id);
		$criteria->compare('empresa',$this->empresa,true);
		$criteria->compare('data_criacao',$this->data_criacao,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('data_inicio',$this->data_inicio,true);
		$criteria->compare('data_termino',$this->data_termino,true);
		$criteria->compare('id_produto',$this->id_produto);
		$criteria->compare('id_wbs',$this->id_wbs);
		//$criteria->compare('id_wbs_destino',$this->id_wbs_destino);
		$criteria->compare('id_cliente',$this->id_cliente);
		$criteria->compare('turno',$this->turno,true);
		$criteria->compare('quantidade',$this->quantidade);
		$criteria->compare('valor',$this->valor);
		$criteria->compare('moeda',$this->moeda,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('pagamento',$this->pagamento,true);
		$criteria->compare('texto_header',$this->texto_header,true);
		$criteria->compare('referencia',$this->referencia,true);
		$criteria->compare('obs',$this->obs,true);
		$criteria->compare('status_fechado',$this->status_fechado);
		
		$criteria->order='id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DeliveryPedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function isOpen($id){
		return ((!self::model()->findByPk($id)->status_cancelado) && (!self::model()->findByPk($id)->status_fechado));
	}
	
	public static function getProdutos($idPedido){
		//return '';
		//Yii::import('application.modules.erpnet.models.ErpnetOrdemItem');
		//Yii::import('application.modules.erpnet.models.ErpnetProduto');
		$produtos='';
		$data= new DbAccess();
		$arr=$data->getErpnetOrdemItem(null,$idPedido);

		if (is_array($arr))	foreach ($arr as $item) {
			//$produto=$data->getErpnetProdutos(false,$item->id_produto);
			//Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($produto).'</pre>'),'teste');
			$produtos=$produtos.$item->quantidade.'x'.$data->getErpnetProdutos(false,$item->id_produto)->descricao.', ';
		}

		return substr($produtos, 0,strlen($produtos)-2);
	}

	public function afterValidate() {
		if ($this->hasErrors()) {
			Helpers::registraErro($this->getErrors());
		} else {
			//Converte data de aniversário para timestamp
			//$this->aniversario = CDateTimeParser::parse($this->aniversario, Yii::app()->locale->getDateFormat('medium'));
		}
		parent::afterValidate();
	}

	public function beforeValidate(){
		$this->usuario=Yii::app()->user->social_identifier;
		$this->empresa=Yii::app()->user->empresa;

		return parent::beforeValidate();
	}
}
