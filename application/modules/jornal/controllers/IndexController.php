<?php

class Jornal_IndexController extends Zend_Controller_Action {

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
              ->allow('admin','add');
      $action = $this->_request->getActionName();
      if (!$acl->isAllowed($permissao,$action)){
         $this->_helper->FlashMessenger(array('erro' => 'Você não tem permissão para acessar esse módulo!!'));
         $this->_redirect('/jornal');
      }
   }


   public function indexAction() {
      $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
      $row = $db->fetchAll('select * from jornal');
      $paginator = Zend_Paginator::factory($row);
      $paginator->setCurrentPageNumber($this->_getParam('page', 1));
      $paginator->setItemCountPerPage(2);
      $paginator->setPageRange(5);
      $paginator->setDefaultScrollingStyle('Sliding');
      Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator_control.phtml');
      $this->view->data = $paginator;
   }

   public function addAction() {
      $form = new Jornal_Form_Jornal();
      $model = new Jornal_Model_Jornal();
      $id = $this->_getParam('id');
      if ($this->_request->isPost()) {
         if ($form->isValid($this->_request->getPost())) {
            $data = $form->getValues();
            if ($id) {
               $where = $model->getAdapter()->quoteInto('jor_codigo = ?', $id);
               $resp = $model->update($data, $where);
            } else {
               $model->insert($data);
            }
            $this->_redirect('/jornal');
         }
      } elseif ($id) {
         $data = $model->busca($id);
         if (is_array($data)) {
            $form->setAction('/jornal/index/add/id/' . $id);
            $form->populate($data);
         }
      }
      $this->view->form = $form;
   }

   public function deleteAction() {
      $model = new Jornal_Model_Jornal();
      $id = $this->_getParam('id');
      if ($id) {
         $where = $model->getAdapter()->quoteInto('jor_codigo = ?', $id);
         $model->delete($where);
      }
      $index = $this->_redirect('/jornal/');
      $this->view->form = $index;
   }

   public function relatorioAction() {
      $pdf = new FPDF('P', 'cm', 'A4'); //paisagem, em centímetros e tipo A4
      $pdf->SetAuthor('Luciano Martins');
      $pdf->SetTitle('Documento gerado com o FPDF');
      $pdf->SetMargins(3, 3, 2);
      $pdf->AddPage();
      $pdf->SetFont('Arial', 'BIU', 10); //tipo de fonte, detalhe da fonte (Bold, Italic, Underlined), tamanho
      //$pdf->SetXY(3, 3);
      //$pdf->Write(0.5, 'Texto a ser inserido ao documento.'); //Texto ou variável
      $pdf->Cell(0, 2, 'CONAL - Controle Financeiro Pessoal', 0, 1, 'C');
      $pdf->Ln(); //pula linha
      $pdf->SetFont('Arial', '', 10);
      $texto = "Você que utiliza o Ubuntu, já deve ter notado que vários
            aplicativos que instalamos, não nos dão permissão
            para alterar seu conteúdo, isso é uma garantia que
            você não vê alterar configurações de modo errado,
            fazendo com que o aplicativo em questão deixe de
            funcionar corretamente, ou em alguns casos, fazendo com que o sistema deixe de inicializar.";
      //$pdf->Write(0.5, 'Segunda linha.');
      $pdf->MultiCell(0, 0.5, $texto, 0, 'J');
      $pdf->Output('exemplo.pdf'); //nome do arquivo
      header("Location:/exemplo.pdf", true);
      // depois de carregado na tela deletá o mesmo fisicamente
      unlink("/exemplo.pdf");
   }

}

