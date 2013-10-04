<?php

class EmpresaAluno_Model_EmpresaAluno extends Zend_Db_Table_Abstract {

   protected $_name = 'aluno_empresa';
   protected $_referenceMap =array(
        'empresa' => array
            ('refTableClass' => 'Empresa_Model_Empresa',
            'refColumns' => array('emp_codigo'),
            'columns' => array('emp_codigo')
        ),
        'aluno' => array(
            'refTableClass' => 'Aluno_Model_Aluno',
            'refColumns' => array('alu_codigo'),
            'columns' => array('alu_codigo')
        )
    );

   public function busca($idEmpresa,$idAluno) {
      try {
         $sql = $this->select()
                 ->where("emp_codigo = '$idEmpresa' AND alu_codigo = '$idAluno'");
//         var_dump($idEmpresa.'-'.$idAluno.'-'.$sql);die;
         $row = $this->fetchRow($sql);
         if (null !== $row)
            return $row->toArray();
      } catch (Exception $e) {
         return $e->getMessage();
      }
   }

}

//         array
//       (
//       array(
//           'refTableClass' => 'Empresa_Model_Empresa',
//           'refColumns' => 'emp_codigo',
//           'columns' => 'emp_codigo',
//       ),
//       array(
//           'refTableClass' => 'Aluno_Model_Aluno',
//           'refColumns' => 'alu_codigo',
//           'columns' => 'alu_codigo',
//       )