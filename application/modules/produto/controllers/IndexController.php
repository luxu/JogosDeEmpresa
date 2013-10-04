<?php

class Produto_IndexController extends Zend_Controller_Action {

    public function preDispatch() {
        parent::preDispatch();
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_helper->FlashMessenger(array('erro' => 'Acesso negado'));
            $this->_redirect('/');
        }
    }

    public function indexAction() {
        $cargo = new Produto_Model_Produto();
        $db = Zend_Db_Table::getDefaultAdapter();// pega uma instancia do Banco de Dados
        $row = $db->fetchAll('select * from produto');
        $paginator = Zend_Paginator::factory($row);//die;
        $paginator->setCurrentPageNumber($this->_getParam('page',1));
        $paginator->setItemCountPerPage(2);
        $paginator->setPageRange(5);
        $paginator->setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
        $this->view->data = $paginator;
    }

    public function addAction() {
        $form = new Produto_Form_Produto();
        $model = new Produto_Model_Produto();
        $id = $this->_getParam('id');
        if($this->_request->isPost()){
            if ($form->isValid($this->_request->getPost())){
                $data = $form->getValues();
                if($id){
                    $resp = $model->update($data, $id);
                }else{
                    $model->insert($data);
                }
                $this->_redirect('/produto');
            }
        }
        elseif ($id){
            $data = $model->busca($id);
            if(is_array($data)){
                $form->setAction('/produto/index/add/id/'.$id);
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

     public function deleteAction(){
        $model = new Produto_Model_Produto();
        $id = $this->_getParam('id');
        if($id){
            $where = $model->getAdapter()->quoteInto('pro_codigo = ?',$id);
            $model->delete($where);
        }
        $index = $this->_redirect('/produto/');
        $this->view->form = $index;
    }


}

