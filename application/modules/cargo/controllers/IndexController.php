<?php

class Cargo_IndexController extends Zend_Controller_Action {

    public function preDispatch() {
        parent::preDispatch();
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_helper->FlashMessenger(array('erro' => 'Acesso negado'));
            $this->_redirect('/');
        }
    }

    public function init() {
        
    }

    public function indexAction() {
        $cargo = new Cargo_Model_Cargo();
        $db = Zend_Db_Table::getDefaultAdapter();// pega uma instancia do Banco de Dados
        $row = $db->fetchAll('select * from cargo');
        $paginator = Zend_Paginator::factory($row);//die;
        $paginator->setCurrentPageNumber($this->_getParam('page',1));
        $paginator->setItemCountPerPage(2);
        $paginator->setPageRange(5);
//        $paginator->setDefaultScrollingStyle('Elastic');
        $paginator->setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
        $this->view->data = $paginator;
    }

    public function addAction()
    {
        // para acessar aki: /cargo/index/add
        $form = new Cargo_Form_Cargo(); //Default_Form_Post();
        $model = new Cargo_Model_Cargo; //Default_Model_Post;
        $id = $this->_getParam('id');
        if($this->_request->isPost()){
            if($form->isValid($this->_request->getPost())){
                $data = $form->getValues();
                if($id){
                    $where = $model->getAdapter()->quoteInto('car_codigo = ?',$id);
                    $model->update($data,$where);
                }else{
                    $model->insert($data);
                }
                $this->_redirect('/cargo');
            }
        }elseif($id){
            $data = $model->busca($id);
            if(is_array($data)){
                $form->setAction('/cargo/index/add/id/' . $id);
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function deleteAction(){
        $model = new Cargo_Model_Cargo();
        $id = $this->_getParam('id');
        if($id){
            $where = $model->getAdapter()->quoteInto('car_codigo = ?',$id);
            $model->delete($where);
        }
        $index = $this->_redirect('/cargo/');
//        $this->view->form = $index;
    }
}

