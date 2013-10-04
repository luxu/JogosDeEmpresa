<?php

class ProdD_Model_ProdD extends Zend_Db_Table_Abstract {

   protected $_name = 'Prodd';
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
      $row = $db->fetchRow('select * from prodd where per_codigo = ?', $id);
      if (null !== $row)
         return $row; //->toArray();

   }

}

