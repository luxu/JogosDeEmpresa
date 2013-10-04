<?php

class Cargo_Model_Cargo extends Zend_Db_Table_Abstract{

    protected $_name = 'cargo';

    public function info(){
        return 'Esta é uma informação do CARGO!!';
    }

    public function busca($id){
        $db = Zend_Db_Table::getDefaultAdapter();// pega uma instancia do Banco de Dados
        $row = $db->fetchRow('select * from cargo where car_codigo = ?',$id);
//        var_dump($row);
//        die;
        if(null !== $row)
                return $row; //->toArray();
    }
}
?>
