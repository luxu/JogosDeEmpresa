<?php

class Jogo_Model_Jogo extends Zend_Db_Table_Abstract {

    protected $_name = 'jogo';
    protected $_dependentTables = array('JogoEmpresa_Model_JogoEmpresa','EmpresaAluno_Model_EmpresaAluno');

    public function busca($id) {
        $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
        $row = $db->fetchRow('select * from jogo where jog_codigo = ?', $id);
        if (null !== $row)
            return $row; //->toArray();
    }
}