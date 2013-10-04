<?php

class Empresa_Model_Empresa extends Zend_Db_Table_Abstract{

    protected $_name = 'empresa';
    protected $_dependentTables = array(
        'JogoEmpresa_Model_JogoEmpresa'
        );

    public function busca($id) {
        $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
        $row = $db->fetchRow('select * from empresa where emp_codigo = ?', $id);
        if (null !== $row)
            return $row; //->toArray();
    }
}