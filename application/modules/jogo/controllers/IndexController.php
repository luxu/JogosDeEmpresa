<?php

class Jogo_IndexController extends Zend_Controller_Action {

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
        $db = Zend_Db_Table::getDefaultAdapter();// pega uma instancia do Banco de Dados
        $row = $db->fetchAll('select * from jogo');
        $paginator = Zend_Paginator::factory($row);//die;
        $paginator->setCurrentPageNumber($this->_getParam('page',1));
        $paginator->setItemCountPerPage(2);
        $paginator->setPageRange(5);
        $paginator->setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
        $this->view->data = $paginator;
    }

    public function addAction(){
        // para acessar aki: /jogo/index/add
        $form = new Jogo_Form_Jogo();
        $model = new Jogo_Model_Jogo;
        $id = $this->_getParam('id');
        if($this->_request->isPost()){
            if($form->isValid($this->_request->getPost())){
                $data = $form->getValues();
                // se vier data vazia atribui-se NULO ao campo jog_inicio
                if ($data['jog_inicio'] == '') $data['jog_inicio'] = NULL;
                if ($data['jog_termino'] == '') $data['jog_termino'] = NULL;
                if($id){
                    $where = $model->getAdapter()->quoteInto('jog_codigo = ?',$id);
                    $model->update($data,$where);
                }else{
                    $model->insert($data);
                }
                $this->_redirect('/jogo');
            }
        }elseif($id){
            $data = $model->busca($id);
            if(is_array($data)){
                $form->setAction('/jogo/index/add/id/' . $id);
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

     public function deleteAction(){
        $model = new Jogo_Model_Jogo;
        $id = $this->_getParam('id');
        if($id){
            $where = $model->getAdapter()->quoteInto('jog_codigo = ?',$id);
            $model->delete($where);
        }
        $index = $this->_redirect('/jogo/');
        $this->view->form = $index;
    }

}

