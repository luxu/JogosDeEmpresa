<?php

class ProdB_Model_ProdB extends Zend_Db_Table_Abstract {

   protected $_name = 'Prodb';
   protected $_dependentTables = array('periodo');
   protected $_referenceMap = array(
       'periodo' => array
           (
           'columns' => 'per_codigo',
           'refTableClass' => 'Periodo_Model_Periodo',
           'refColumns' => 'per_codigo'
       )
   );

   public function busca($id) {
      $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
      $row = $db->fetchRow('select * from prodb where per_codigo = ?', $id);
      if (null !== $row)
         return $row; //->toArray();

   }

}

