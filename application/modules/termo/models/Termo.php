<?php

class Termo_Model_Termo extends Zend_Db_Table_Abstract{

    protected $_name = 'termo';
    protected $_dependentTables = array(
        'Aluno_Model_Aluno'
        );


    public function busca($id){
        $db = Zend_Db_Table::getDefaultAdapter();// pega uma instancia do Banco de Dados
        $row = $db->fetchRow('select * from termo where ter_codigo = ?',$id);
        if(null !== $row)
                return $row; //->toArray();
    }
}
?>
