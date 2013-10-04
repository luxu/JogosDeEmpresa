<?php

class Usuario_Model_Usuario extends Zend_Db_Table_Abstract {

    protected $_name = 'usuario';
    protected $_referenceMap = array(
        'aluno' => array('columns' => 'alu_codigo','refTableClass' => 'Aluno_Model_Aluno','refColumns' => 'alu_codigo'),
        'coordenador' => array('columns' => 'coo_codigo','refTableClass' => 'Coordenador_Model_Coordenador','refColumns' => 'coo_codigo')
        );

    public function busca($id) {
        $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
        $row = $db->fetchRow('select * from usuario where alu_codigo = ?', $id);
        if (null !== $row)
            return $row; //->toArray();

    }

}

