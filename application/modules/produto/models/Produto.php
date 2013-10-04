<?php

class Produto_Model_Produto extends Zend_Db_Table_Abstract{

    protected $_name = 'produto';

    public function busca($id) {
        $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
        $row = $db->fetchRow('select * from produto where pro_codigo = ?', $id);
        if (null !== $row)
            return $row; //->toArray();
    }
}