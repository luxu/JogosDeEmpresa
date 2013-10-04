<?php

class Termo_IndexController extends Zend_Controller_Action {

    public function preDispatch() {
        parent::preDispatch();
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_helper->FlashMessenger(array('erro' => 'Acesso negado'));
            $this->_redirect('/');
        }
    }

    public function indexAction() {
	/*
	        $cache = Zend_Registry::get('cache');
		if(!$result = $cache->load('cacheTermos')) {
			$db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
			$result = $db->fetchAll('select * from termo');
			$cache->save($result, 'cacheTermos');
		}
		*/
        $termo = new Termo_Model_Termo();
        $db = Zend_Db_Table::getDefaultAdapter();// pega uma instancia do Banco de Dados
        $row = $db->fetchAll('select * from termo');
        $paginator = Zend_Paginator::factory($row);//die;
        $paginator->setCurrentPageNumber($this->_getParam('page',1));
        $paginator->setItemCountPerPage(2);
        $paginator->setPageRange(5);
        $paginator->setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
        $this->view->data = $paginator;
    }

    public function addAction(){
	
        $form = new Termo_Form_Termo();
        $model = new Termo_Model_Termo();
        $id = $this->_getParam('id');
        if($this->_request->isPost()){
            if($form->isValid($this->_request->getPost())){
                $data = $form->getValues();
                if($id){
                    $where = $model->getAdapter()->quoteInto('ter_codigo = ?',$id);
                    $model->update($data,$where);
                }else{
                    $model->insert($data);
                }
				$cache = Zend_Registry::get('cache');
				$cache->remove('cacheTermos');
                $this->_redirect('/termo');
            }
        }elseif($id){
            $data = $model->busca($id);
            if(is_array($data)){
                $form->setAction('/termo/index/add/id/' . $id);
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function deleteAction(){
        $model = new Termo_Model_Termo();
        $id = $this->_getParam('id');
        if($id){
            $where = $model->getAdapter()->quoteInto('ter_codigo = ?',$id);
            $model->delete($where);
			$cache = Zend_Registry::get('cache');
			$cache->remove('cacheTermos');
			$this->_redirect('/termo');
        }
        $index = $this->_redirect('/termo/');
        $this->view->form = $index;
    }
}

