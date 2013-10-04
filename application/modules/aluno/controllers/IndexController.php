<?php

class Aluno_IndexController extends Zend_Controller_Action {

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
        $row = $db->fetchAll('select * from aluno');
        $paginator = Zend_Paginator::factory($row);
        $paginator->setItemCountPerPage(3);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setPageRange(5);
        $paginator->setDefaultScrollingStyle('Elastic');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
        $this->view->data = $paginator;
    }

    public function addAction() {
        $form = new Aluno_Form_Aluno();
        $model = new Aluno_Model_Aluno();
        $id = $this->_getParam('id');
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $data = $form->getValues();
                $termo = $data['ter_codigo'];
                $curso = $data['cur_codigo'];
//                echo $termo[0]." - ".$curso[0];die;
                $data['ter_codigo'] = $termo[0];
                $data['cur_codigo'] = $curso[0];
                if ($id) {
                    $resp = $model->update($data, $id);
                } else {
                    $model->insert($data);
                }
                $this->_redirect('/aluno');
            }
        } elseif ($id) {
            $data = $model->busca($id);
            if (is_array($data)) {
                $form->setAction('/aluno/index/add/id/' . $id);
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function deleteAction(){
        $model = new Usuario_Model_Usuario();
        $id = $this->_getParam('id');
        if($id){
            $where = $model->getAdapter()->quoteInto('alu_codigo = ?',$id);
            $model->delete($where);
        }
        $index = $this->_redirect('/aluno/');
        $this->view->form = $index;
    }

    //$db = Zend_Db_Table::getDefaultAdapter();// pega uma instancia do Banco de Dados
    //$row = $db->fetchRow('select * from cargo');
    //$row = $db->fetchRow('select * from cargo where car_codigo = ?',1);
    //$ins = $db->insert('cargo', array('car_descricao'=>'Adm. Contas'));
    //$ultimoid = $db->lastInsertId();
    //$ins = $db->update('cargo', array('car_descricao'=>'Administrador Contas'),"car_codigo=3");
    //$ins = $db->delete('cargo', "car_codigo=3");
    //$db->setFetchMode(Zend_Db::FETCH_OBJ); // passa o conteúdo q está numa array para ser lido como objeto no index.phtml
    //$row = $db->fetchAll("select * from cargo");
    //$cargo = new Application_Model_Cargo();
    //$find = $cargo->find(1)->current();
    // pega o q tem relacionada no codigo 1
    //$usuario = $find->findDependentRowset('Application_Model_Usuario');
//        $model = new Default_Model_Usuario();
//        $usuario = $model->find(1);
//        $find = $usuario->current()->findParentRow('Default_Model_Cargo');
//        $rows = $cargo->lista();
//        $sql = $cargo->sql();
    //var_dump($usuario);
    // inserir os dados
    //$ins = $cargo->inserir(array('car_descricao'=>'Adm. Total','salvar'=>'salvar'));
    //$ins = $cargo->update(array('car_descricao'=>'Tott'),5);
    //$ins = $cargo->delete(5);
    //echo "<br>Ultimo codigo inserido: $ins";
    //View
//        $this->view->usuario = $usuario;
//        $this->view->cargo = $find;
//        $this->view->titulo = "Cargos";
    //$this->view->usuarios = $sql;
}

