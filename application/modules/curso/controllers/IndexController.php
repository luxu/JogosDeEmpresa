<?php

class Curso_IndexController extends Zend_Controller_Action {

    public function preDispatch() {
        parent::preDispatch();
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_helper->FlashMessenger(array('erro' => 'Acesso negado'));
            $this->_redirect('/');
        }
    }

    public function indexAction() {
        $cache = Zend_Registry::get('cache');
		if(!$result = $cache->load('cacheCursos')) {
			$db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
			$result = $db->fetchAll('select * from curso');
			$cache->save($result, 'cacheCursos');
		}
        $paginator = Zend_Paginator::factory($result);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(2);
        $paginator->setPageRange(5);
        $paginator->setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
        $this->view->data = $paginator;
    }

    public function addAction() {
        $form = new Curso_Form_Curso(); 
        $model = new Curso_Model_Curso();
        $id = $this->_getParam('id');
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $data = $form->getValues();
                if ($id) {
                    $where = $model->getAdapter()->quoteInto('cur_codigo = ?', $id);
                    $model->update($data, $where);
                } else {
                    $model->insert($data);
                }
				$cache = Zend_Registry::get('cache');
				$cache->remove('cacheCursos');
                $this->_redirect('/curso');
            }
        } elseif ($id) {
            $data = $model->busca($id);
            if (is_array($data)) {
                $form->setAction('/curso/index/add/id/' . $id);
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function deleteAction() {
        $model = new Cargo_Model_Cargo();
        $id = $this->_getParam('id');
        if ($id) {
            $where = $model->getAdapter()->quoteInto('cur_codigo = ?', $id);
            $model->delete($where);
			$cache = Zend_Registry::get('cache');
			$cache->remove('cacheCursos');
        }
        $index = $this->_redirect('/curso/');
//        $this->view->form = $index;
    }

}

