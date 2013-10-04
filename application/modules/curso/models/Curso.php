<?php

class Curso_Model_Curso extends Zend_Db_Table_Abstract{

    protected $_name = 'curso';
    protected $_dependentTables = array(
        'Aluno_Model_Aluno'
        );

    public function busca($id){
        $db = Zend_Db_Table::getDefaultAdapter();// pega uma instancia do Banco de Dados
        $row = $db->fetchRow('select * from curso where cur_codigo = ?',$id);
        if(null !== $row)
                return $row; //->toArray();
    }
}
?>
