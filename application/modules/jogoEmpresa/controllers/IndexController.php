<?php

class JogoEmpresa_IndexController extends Zend_Controller_Action {

    public function preDispatch() {
        parent::preDispatch();
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_helper->FlashMessenger(array('erro' => 'Acesso negado'));
            $this->_redirect('/');
        }
    }

    public function indexAction() {
        $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
        $row = $db->fetchAll('select * from empresa_jogo');
        $paginator = Zend_Paginator::factory($row); //die;
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);
        $paginator->setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
        $this->view->data = $paginator;
    }

    public function addAction() {
        // para acessar aki: /jogo/index/add
        $form = new JogoEmpresa_Form_JogoEmpresa();
        $model = new JogoEmpresa_Model_JogoEmpresa();
        $idJogo = $this->_getParam('idJogo');
        $idEmpresa = $this->_getParam('idEmpresa');
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $data = $form->getValues();
                if ($idJogo) {
                     $db = $model->getAdapter();
                     $where = $db->quoteInto('jog_codigo=?',$idJogo)
                             . $db->quoteInto(' AND emp_codigo=?',$idEmpresa);
                    $model->update($data, $where);
                } else {
                    $model->insert($data);
                }
                $this->_redirect('/jogoEmpresa');
            }
        } elseif ($idJogo) {
           $data = $model->busca($idJogo,$idEmpresa);
            if (is_array($data)) {
               $form->setAction('/jogoEmpresa/index/add/idJogo/' . $idJogo . '/idEmpresa/' . $idEmpresa);
               $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function deleteAction() {
        $model = new JogoEmpresa_Model_JogoEmpresa();
        $idJogo = $this->_getParam('idJogo');
        $idEmpresa = $this->_getParam('idEmpresa');
        if ($idJogo) {
                 $db = $model->getAdapter();
                 $where = $db->quoteInto('jog_codigo=?',$idJogo)
                         . $db->quoteInto(' AND emp_codigo=?',$idEmpresa);
           $model->delete($where);
        }
        $index = $this->_redirect('/jogoEmpresa/');
        $this->view->form = $index;
    }
}

