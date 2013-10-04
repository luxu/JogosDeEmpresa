<?php

class EmpresaAluno_IndexController extends Zend_Controller_Action {

   public function preDispatch() {
      parent::preDispatch();
      $auth = Zend_Auth::getInstance();
      if (!$auth->hasIdentity()) {
         $this->_helper->FlashMessenger(array('erro' => 'Acesso negado'));
         $this->_redirect('/');
      }
   }

   public function  init() {
      $usuario = Zend_Auth::getInstance()->getStorage()->read();
      if(isset($usuario->alu_acesso)){
         $permissao = 'aluno';
      } else{
         $permissao = 'admin';
      }
      $acl = new Zend_Acl();
      $aluno = new Zend_Acl_Role('aluno');
      $acl->addRole($aluno)
              ->addRole(new Zend_Acl_Role('admin'), 'aluno')
              ->add(new Zend_Acl_Resource('index'))
              ->add(new Zend_Acl_Resource('add'))
              ->add(new Zend_Acl_Resource('delete'))
              ->add(new Zend_Acl_Resource('relatorio'))
              ->allow('aluno',array('index','relatorio'))
              ->allow('admin',array('add','delete'));
      $action = $this->_request->getActionName();
      if (!$acl->isAllowed($permissao,$action)){
         $this->_helper->FlashMessenger(array('erro' => 'Você não tem permissão para acessar esse módulo!!'));
         $this->_redirect('/empresaAluno');
      }
   }
   
   public function indexAction() {

      $cache = Zend_Registry::get('cache');
      if (!$row = $cache->load('cacheAlunoEmpresa')) {
         //não existe no cache, processar e salvar
         $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
         $row = $db->fetchAll('select * from aluno_empresa');
         $cache->save($row, 'cacheAlunoEmpresa');
      }
      $paginator = Zend_Paginator::factory($row);
      $paginator->setCurrentPageNumber($this->_getParam('page', 1));
      $paginator->setItemCountPerPage(10);
      $paginator->setPageRange(5);
      $paginator->setDefaultScrollingStyle('Sliding');
      Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
      $this->view->data = $paginator;
   }

   public function addAction() {
      // para acessar aki: /empresaAluno/index/add
      $form = new EmpresaAluno_Form_EmpresaAluno();
      $model = new EmpresaAluno_Model_EmpresaAluno();
      $idEmpresa = $this->_getParam('idEmpresa');
      $idAluno = $this->_getParam('idAluno');
      if ($this->_request->isPost()) {
         if ($form->isValid($this->_request->getPost())) {
            $data = $form->getValues();
//            $salario = $data['ae_salario'];
//            ($salario)?'': $data['ae_salario'] = 0;
            if ($idEmpresa) {
               $db = $model->getAdapter();
               $where = $db->quoteInto('emp_codigo=?',$idEmpresa)
                       . $db->quoteInto(' AND alu_codigo=?',$idAluno);
               $model->update($data, $where);
            } else {
               $model->insert($data);
            }
            $cache = Zend_Registry::get('cache');
            $result = $cache->remove('cacheAlunoEmpresa');
            $this->_redirect('/empresaAluno');
         }
      } elseif ($idEmpresa) {
         $data = $model->busca($idEmpresa,$idAluno);
         if (is_array($data)) {
            $form->setAction('/empresaAluno/index/add/idEmpresa/' . $idEmpresa . '/idAluno/' . $idAluno);
            $form->populate($data);
         }
      }
      $this->view->form = $form;
   }

   public function deleteAction() {
      $model = new EmpresaAluno_Model_EmpresaAluno();
      $idEmpresa = $this->_getParam('idEmpresa');
      $idAluno = $this->_getParam('idAluno');
      if ($idEmpresa) {
               $db = $model->getAdapter();
               $where = $db->quoteInto('emp_codigo=?',$idEmpresa)
                       . $db->quoteInto(' AND alu_codigo=?',$idAluno);
         $model->delete($where);
      }
      $cache = Zend_Registry::get('cache');
      $result = $cache->remove('cacheAlunoEmpresa');
      $index = $this->_redirect('/empresaAluno/');
      $this->view->form = $index;
   }
}

//
//        var_dump($this->_request);die;
//
//       $jogo = new Jogo_Model_Jogo();
//       $aluno = new Aluno_Model_Aluno();
//       $rEmpresa = $aluno->find()->current();
//        $empresa = new Empresa_Model_Empresa();
//        $JogoEmpresa = $empresa->find(1)->current();
//       $aluno->find(1)->current();
//        $alunos = $JogoEmpresa->findManyToManyRowset('Empresa_Model_Empresa', 'EmpresaAluno_Model_EmpresaAluno');
//        $alunos = $JogoEmpresa->findAluno_Model_AlunoViaEmpresaAluno_Model_EmpresaAluno();
//        $allEmpresas = $alunos->toArray();
//        var_dump($allEmpresas);die;
//        $rJogo = $jogo->find(1)->current();// busca na tabela aluno
//         duas formas de fazer uma busca nas tabelas relacionadas: veja abaixo
//        $empresas = $rJogo->findManyToManyRowset('Empresa_Model_Empresa', 'JogoEmpresa_Model_JogoEmpresa');
//        $empresas = $rJogo->findEmpresa_Model_EmpresaViaJogoEmpresa_Model_JogoEmpresa();
//        $allEmpresas = $empresas->toArray();
// pega uma instancia do Banco de Dados
//
