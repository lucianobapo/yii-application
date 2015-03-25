<?php
/**
 * Created by PhpStorm.
 * User: Luciano
 * Date: 13/02/2015
 * Time: 13:22
 */

class DbAccess extends CDbConnection {

    //private $_connection=null;
    //private $_class=get_class($this);
    private $_cache=null;

    private function getDataCache($key){
        $class=get_class($this);
        if(Yii::app()->params['queryCache']["$class"]['cachingDuration']>0
            && Yii::app()->params['queryCache']["$class"]['cacheID']!==false
            && ($this->_cache=Yii::app()->getComponent(Yii::app()->params['queryCache']["$class"]['cacheID']))!==null){

            if(($data=$this->_cache->get($key))!==false) {
                Yii::trace('Servindo dados do cache',$key);
                //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($data).'</pre>'),'teste.getDataCache');
                //echo ('<pre>'.CVarDumper::dumpAsString($data).'</pre>');
                //retorna os dados do cache
                return unserialize($data);

            } else {
                Yii::trace('Dados não encontrados no cache',$key);
                return false;
            }
        } else return false;
    }

    private function setDataCache($key,$dataReader,$table){
        $class=get_class($this);
        //set cache
        if($this->_cache!==null) {
            $dependency = new CDbCacheDependency('SELECT MAX(data_update),COUNT(*) FROM '.$table);
            Yii::trace('Inserindo dados no cache',$key);
            $this->_cache->set($key,serialize($dataReader),Yii::app()->params['queryCache']["$class"]['cachingDuration'],$dependency);
            return true;
        } else return false;
    }

    public function getErpnetProdutos($destaque=false,$id=null){
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($destaque).'</pre>'),'teste.getErpnetProdutos');
        $key=get_class($this).".getErpnetProduto.$destaque.$id";
        if (($dataReader=$this->getDataCache($key))===false) {
            $dataReader=Yii::app()->db->createCommand();
            $dataReader->select('*');
            $dataReader->from('erpnet_produto p');
            if ($id===null) $dataReader->join('erpnet_grupo_has_produto g', 'g.id_grupo_produto='.Yii::app()->params['grupoDelivery'].' and p.id=g.id_produto');
            if ($destaque) $dataReader->andWhere("p.destaque=1");
            if ($id!==null) $dataReader->andWhere("p.id=$id");
            $dataReader->andWhere("p.ativado=1");
            $dataReader->order("promocao desc, descricao");
            //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($dataReader->text).'</pre>'),'teste.getErpnetProdutos');

            $dataReader=$dataReader->queryAll();
            $this->setDataCache($key,$dataReader,'erpnet_produto');
        }

        //echo ('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>');
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>'),'teste.getErpnetProdutos2');

        foreach ($dataReader as $key=>$array) $objeto[$key]=(object)$array;
        if (count($objeto)==1) $objeto=$objeto[0];
        return $objeto;
    }

    public function getErpnetEstoque($produto=null){
        if (empty($produto))  return null;
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($produto).'</pre>'),'teste');
        $key=get_class($this).'.getErpnetEstoque.'.$produto;
        if (($dataReader=$this->getDataCache($key))===false) {
            $dataReader=Yii::app()->db->createCommand();
            $dataReader->reset();
            $dataReader->select('*');
            $dataReader->from('erpnet_estoque e'.$produto);
            $dataReader->where('e'.$produto.'.id_produto='.$produto);
            $dataReader=$dataReader->queryAll();
            $this->setDataCache($key,$dataReader,'erpnet_estoque');
        }
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>'),$key);
        //echo ('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>');

        //$objeto=(object)array('');
        $retorno='';
        if (is_array($dataReader)) foreach ($dataReader as $key=>$array) $retorno[$key]=(object)$array;
        return $retorno;
    }

    public function getErpnetOrdemItem($produto=null,$ordem=null){
        if (empty($ordem)) return null;
        $key=get_class($this).".getErpnetOrdemItem.$produto.$ordem";
        if (($dataReader=$this->getDataCache($key))===false) {
            $dataReader=Yii::app()->db->createCommand();
            $dataReader->reset();
            $dataReader->select('*');
            $dataReader->from('erpnet_ordem_item i');
            $dataReader->where('i.id_ordem=:ordem',array(':ordem'=>$ordem));
            if ($produto!==null) $dataReader->andWhere('i.id_produto=:produto',array(':produto'=>$produto));

            $dataReader=$dataReader->queryAll();
            $this->setDataCache($key,$dataReader,'erpnet_ordem_item');
        }

        if (is_array($dataReader)&&(count($dataReader)>0)) {
            if (count($dataReader)==1){
                $erpnet=Yii::app()->getModule('erpnet');
                $object= new ErpnetOrdemItem();
                $object->attributes=$dataReader[0];
                //return (object)$dataReader[0];
                return $object;
                //return new ErpnetOrdemItem();
            } else {
                $retorno=array();
                foreach ($dataReader as $key=>$array) $retorno[$key]=(object)$array;
                return $retorno;
            }
            //return $dataReader;
        } else return null;
    }

    public function getPreferencia($produto=null){
        //if (empty($produto))  return null;
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($produto).'</pre>'),'teste');
        $key=get_class($this).'.getPreferencia.'.$produto;
        if (($dataReader=$this->getDataCache($key))===false) {
            $dataReader=Yii::app()->db->createCommand();
            $dataReader->reset();
            $dataReader->select('sum(i.quantidade) itens');
            $dataReader->from('erpnet_ordem_item i, erpnet_ordem e');
            $dataReader->where("i.id_ordem=e.id");
            $dataReader->andWhere('e.tipo="venda"');
            $dataReader->andWhere('e.empresa="ilhanet"');
            if ($produto!==null) $dataReader->andWhere('i.id_produto='.$produto);
            //$text=$dataReader->text;
            $dataReader=$dataReader->queryAll();
            $this->setDataCache($key,$dataReader,'erpnet_ordem_item');
        }
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>'),$key);
        //echo ('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>');

        $retorno=0;
        if (is_array($dataReader)) $retorno=$dataReader[0]['itens'];
        //return $dataReader;
        return $retorno;
    }

    public function getParceiro($social_identifier=null){
        if ($social_identifier===null)  return null;
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($produto).'</pre>'),'teste');
        $key=get_class($this).'.getParceiro.'.$social_identifier;
        if (($dataReader=$this->getDataCache($key))===false) {
            $dataReader=Yii::app()->db->createCommand();
            $dataReader->reset();
            $dataReader->select('id_cliente');
            $dataReader->from('user');
            $dataReader->where('social_identifier='.$social_identifier);
            //$text=$dataReader->text;
            $dataReader=$dataReader->queryAll();
            $this->setDataCache($key,$dataReader,'user');
        }
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>'),$key);
        //echo ('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>');

        if (is_array($dataReader)&&(count($dataReader)>0)) {
            if (count($dataReader)==1){
                //$erpnet=Yii::app()->getModule('erpnet');
                //$object= new User();
                //$object->attributes=$dataReader[0];
                //return (object)$dataReader[0];
                //return $object;
                //return new ErpnetOrdemItem();
                return (object)$dataReader[0];
            } else {
                $retorno=array();
                foreach ($dataReader as $key=>$array) $retorno[$key]=(object)$array;
                return $retorno;
            }
            //return $dataReader;
        } else return null;
    }

    public function getEndereco($id=null){
        if ($id===null)  return null;
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($produto).'</pre>'),'teste');
        $key=get_class($this).'.getEndereco.'.$id;
        if (($dataReader=$this->getDataCache($key))===false) {
            $dataReader=Yii::app()->db->createCommand();
            $dataReader->reset();
            $dataReader->select('*');
            $dataReader->from('erpnet_enderecos');
            $dataReader->where('id='.$id);
            //$text=$dataReader->text;
            $dataReader=$dataReader->queryAll();
            $this->setDataCache($key,$dataReader,'erpnet_enderecos');
        }
        //Yii::trace('Debug: '.('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>'),$key);
        //echo ('<pre>'.CVarDumper::dumpAsString($dataReader).'</pre>');

        if (is_array($dataReader)&&(count($dataReader)>0)) {
            if (count($dataReader)==1){
                $object= new DeliveryEndereco();
                $object->attributes=$dataReader[0];
                return $object;
                //return (object)$dataReader[0];
            } else {
                $retorno=array();
                foreach ($dataReader as $key=>$array) $retorno[$key]=(object)$array;
                return $retorno;
            }
            //return $dataReader;
        } else return null;
    }


}