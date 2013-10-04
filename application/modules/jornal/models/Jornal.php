<?php

class Jornal_Model_Jornal extends Zend_Db_Table_Abstract{

    protected $_name = 'jornal';
    protected $_referenceMap = array
        (
        'usuario' => array
            (
            'columns' => 'usu_codigo',
            'refTableClass' => 'Usuario_Model_Usuario',
            'refColumns' => 'usu_codigo'
        )
    );

    public function busca($id) {
        $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
        $row = $db->fetchRow('select * from jornal where jor_codigo = ?', $id);
        if (null !== $row)
            return $row; //->toArray();
    }
}