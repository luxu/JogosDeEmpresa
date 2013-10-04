<?php

class Periodo_Model_Periodo extends Zend_Db_Table_Abstract {

   protected $_name = 'periodo';
   protected $_dependentTables = array('aluno', 'empresa');
   protected $_referenceMap = array
       (
       'aluno' => array
           (
           'columns' => 'alu_codigo',
           'refTableClass' => 'Aluno_Model_Aluno',
           'refColumns' => 'alu_codigo'
       ),
       'empresa' => array
           (
           'columns' => 'emp_codigo',
           'refTableClass' => 'Empresa_Model_Empresa',
           'refColumns' => 'emp_codigo'
       )
   );

   public function busca($id) {
      $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
      $row = $db->fetchRow('select * from periodo where emp_codigo = ?', $id);
      if (null !== $row)
         return $row; //->toArray();

   }

}

