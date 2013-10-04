<?php

class JogoEmpresa_Model_JogoEmpresa extends Zend_Db_Table_Abstract {

    protected $_name = 'empresa_jogo';
    protected $_referenceMap =
            array(
        'empresa' => array
            ('refTableClass' => 'Empresa_Model_Empresa',
            'refColumns' => array('emp_codigo'),
            'columns' => array('emp_codigo')
        ),
        'jogo' => array(
            'refTableClass' => 'Jogo_Model_Jogo',
            'refColumns' => array('jog_codigo'),
            'columns' => array('jog_codigo')
        )
    );

    public function busca($id) {
        try {
            $sql = $this->select()
                    ->where('jog_codigo =?', $id);
            $row = $this->fetchRow($sql);
            if (null !== $row)
                return $row->toArray();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}