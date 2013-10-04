<?php

class Empresa_IndexController extends Zend_Controller_Action {

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
            $row = $db->fetchAll('select * from empresa');
            $paginator = Zend_Paginator::factory($row);
            $paginator->setCurrentPageNumber($this->_getParam('page', 1));
            $paginator->setItemCountPerPage(2);
            $paginator->setPageRange(5);
            $paginator->setDefaultScrollingStyle('Sliding');
            Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
            $this->view->data = $paginator;
    }

    public function addAction() {
        $form = new Empresa_Form_Empresa();
        $model = new Empresa_Model_Empresa();
        $id = $this->_getParam('id');
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $data = $form->getValues();
                // se vier data vazia atribui-se NULO ao campo emp_data
                if ($data['emp_data'] == '')
                    $data['emp_data'] = NULL;
                if ($id) {
                    $where = $model->getAdapter()->quoteInto('emp_codigo = ?',$id);
//                    var_dump($where);die;
                    $model->update($data,$where);
                } else {
                    $model->insert($data);
                }
                $this->_redirect('/empresa');
            }
        } elseif ($id) {
            $data = $model->busca($id);
            if (is_array($data)) {
                $form->setAction('/empresa/index/add/id/' . $id);
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

         public function deleteAction(){
        $model = new Empresa_Model_Empresa();
        $id = $this->_getParam('id');
        if($id){
            $where = $model->getAdapter()->quoteInto('emp_codigo = ?',$id);
            $model->delete($where);
        }
        $index = $this->_redirect('/empresa');
        $this->view->form = $index;
    }
}

