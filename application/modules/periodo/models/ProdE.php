<?php

class ProdE_Model_ProdE extends Zend_Db_Table_Abstract {

   protected $_name = 'Prode';
   protected $_dependentTables = array('periodo');
   protected $_referenceMap = array
       (
       'periodo' => array
           (
           'columns' => 'per_codigo',
           'refTableClass' => 'Periodo_Model_Periodo',
           'refColumns' => 'per_codigo'
       )
   );

   public function busca($id) {
      $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
      $row = $db->fetchRow('select * from prode where per_codigo = ?', $id);
      if (null !== $row)
         return $row; //->toArray();

   }

}

