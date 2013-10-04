<?php

class Periodo_IndexController extends Zend_Controller_Action {

   public function preDispatch() {
      parent::preDispatch();
      $auth = Zend_Auth::getInstance();
      if (!$auth->hasIdentity()) {
         $this->_helper->FlashMessenger(array('erro' => 'Acesso negado'));
         $this->_redirect('/');
      }
   }

   public function init() {
      $usuario = Zend_Auth::getInstance()->getStorage()->read();
      if (isset($usuario->alu_acesso)) {
         $permissao = 'aluno';
      } else {
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
              ->allow('aluno', array('index', 'relatorio', 'add'))
              ->allow('admin', 'delete');
      $action = $this->_request->getActionName();
      if (!$acl->isAllowed($permissao, $action)) {
         $this->_helper->FlashMessenger(array('erro' => 'Você não tem permissão para acessar esse módulo!!'));
         $this->_redirect('/periodo');
      }
   }

   public function indexAction() {
//      $cache = Zend_Registry::get('cache');
//      if (!$row = $cache->load('cachePeriodos')) {
//         //não existe no cache, processar e salvar
//         $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
//         $row = $db->fetchAll('select * from periodo');
//         $cache->save($row, 'cachePeriodos');
//      }
      $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
      $row = $db->fetchAll('select * from periodo');
      $paginator = Zend_Paginator::factory($row);
      $paginator->setItemCountPerPage(3);
      $paginator->setCurrentPageNumber($this->_getParam('page'));
      $paginator->setPageRange(5);
      $paginator->setDefaultScrollingStyle('Elastic');
      Zend_View_Helper_PaginationControl::setDefaultViewPartial('Paginator_control.phtml');
      $this->view->data = $paginator;
   }

   public function addAction() {
      $form = new Periodo_Form_Periodo();
      $model = new Periodo_Model_Periodo();
      $id = $this->_getParam('id');
      if ($this->_request->isPost()) {
         if ($form->isValid($this->_request->getPost())) {
            $data = $form->getValues();
            $funcionarioNoFinalDoPeriodoVigente = 
                                    ($data['per_qtdefuncionariosinicial'] + $data['per_qtdefuncionariosadmitidos'])
                                       - $data['per_qtdefuncionariosdemitidos'];
            
            $data['per_qtdefuncionariosfinal'] = $funcionarioNoFinalDoPeriodoVigente;

            $data['per_capitalfinalperiodo'] =
                           $data['per_capitalinicialperiodo'] -
                           ($data['per_qtdefuncionariosfinal'] * 1300);
            $aluno = $data['alu_codigo'];
            $empresa = $data['emp_codigo'];
            $date = new Zend_Date();
            $date->set($data['per_dataentrega'])->get('YYYY-mm-dd');
            $dt = implode("-", array_reverse(explode("/", $data['per_dataentrega'])));
            $data['per_dataentrega'] = $dt;
            if ($id) {
               $where = $model->getAdapter()->quoteInto('per_codigo = ?', $id);
               $model->update($data, $where);
            } else {
               $model->insert($data);
            }
//            $cache = Zend_Registry::get('cache');
//            $result = $cache->remove('cachePeriodos');
            $this->_redirect('/periodo');
         }
      } elseif ($id) {
         $data = $model->busca($id);
         var_dump($data);die;
         if (is_array($data)) {
            $form->setAction('/periodo/index/add/id/' . $id);
            $form->populate($data);
         }
      }
      $this->view->form = $form;
   }

   public function deleteAction() {
      $model = new Periodo_Model_Periodo();
      $id = $this->_getParam('id');
      if ($id) {
         $where = $model->getAdapter()->quoteInto('per_codigo = ?', $id);
         $model->delete($where);
      }
//      $cache = Zend_Registry::get('cache');
//      $result = $cache->remove('cachePeriodos');
      $index = $this->_redirect('/periodo/');
      $this->view->form = $index;
   }

   public function controlAction() {
      echo $_POST["precocompraB"];die;
//      $this->_helper->layout->disableLayout();
//      $this->_helper->viewRenderer->setNoRender(true);
   }

   public function relatorioAction() {
      $mpdf = new mPDF();
      $db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
      $TodosOsCamposDoUltimoPerCodigo =
               $db->fetchRow('SELECT * FROM PERIODO WHERE PER_CODIGO = (SELECT MAX(PER_CODIGO) FROM PERIODO)');
      $array = $TodosOsCamposDoUltimoPerCodigo;
      $nomeEmpresa = $db->fetchRow('SELECT EMP_DESCRICAO FROM EMPRESA WHERE EMP_CODIGO = ?', $array[emp_codigo]);
      $nomeAluno = $db->fetchRow('SELECT EMP_DESCRICAO FROM EMPRESA WHERE EMP_CODIGO = ?', $array[emp_codigo]);
      $date = new Zend_Date($array[per_dataentrega]);
      $date->get(Zend_Date::DATE_SHORT, 'pt_BR');
      $html = '
<html>
   <head>
   <style>
   @page {
     size: auto;
     odd-header-name: MyHeader1;
     odd-footer-name: MyFooter1;
   }
   @page chapter2 {
       odd-header-name: MyHeader2;
       odd-footer-name: MyFooter2;
   }
   @page noheader {
       odd-header-name: _blank;
       odd-footer-name: _blank;
   }
   div.chapter2 {
       page-break-before: always;
       page: chapter2;
   }
   div.noheader {
       page-break-before: always;
       page: noheader;
   }
   </style>
   </head>
   <body>
      <pageheader name="MyHeader1" content-right="My document" header-style="font-weight: bold; color: #000000;" line="on" />
      <pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" footer-style="font-size: 8pt;" />
      <pageheader name="MyHeader2" content-right="Chapter 2" header-style="font-weight: bold; color: #000000;" line="on" />
      <pagefooter name="MyFooter2" content-left="{DATE j-m-Y}" content-center="2: {PAGENO}" footer-style="font-size: 8pt;" />
      <div>

<div id="mae-form"> <!-- Inicio DIV mae-form -->
    <div id="nome-campo">Período: '."$array[per_codigo]".' </div>
    <div id="nome-campo">Empresa: '."$nomeEmpresa[EMP_DESCRICAO]".' </div>
    <div id="nome-campo">Entregue no dia: '."$date".' às: '."$array[per_horaentrega]".' hs</div>
    <div id="nome-campo">Capital Inicial do Período: '."$nomeEmpresa[per_capitalinicialperiodo]".' </div>
    <div id="nome-campo">Capital Final do Período: '."$nomeEmpresa[per_capitalfinalperiodo]".' </div>
    <div id="nome-campo">Qtdade Inicial de Funcionário: '."$nomeEmpresa[per_qtdefuncionariosinicial]".' </div>
    <div id="nome-campo">Qtdade Final de Funcionário: '."$nomeEmpresa[per_qtdefuncionariosfinal]".' </div>
    <div id="nome-campo">Valor gasto com propaganda: '."$nomeEmpresa[per_vlgastopropaganda]".' </div>
    <div id="nome-campo">Valor gasto com treinamento: '."$nomeEmpresa[per_vlgastotreinamento]".' </div>
    <div id="nome-campo">Valor de vendas: '."$nomeEmpresa[per_vlvendas]".' </div>
    <div id="nome-campo">Valor gasto com salário: '."$nomeEmpresa[per_vlgastosalarios]".' </div>
    <div id="nome-campo">Valor gasto com demissão: '."$nomeEmpresa[per_vlgastodemissao]".' </div>
    <div id="nome-campo">Qtde de funcionários demitidos: '."$nomeEmpresa[per_qtdefuncionariosdemitidos]".' </div>
    <div id="nome-campo">Qtde de funcionários contratados: '."$nomeEmpresa[per_qtdefuncionariosadmitidos]".' </div>
<div id="both"></div>
<!-- FIM Exame Composição Corporal -->
</div>
      <div class="chapter2">Text of Chapter 2</div>
      <div class="noheader">No-Header page</div>
   </body>
</html>
';
      $mpdf->WriteHTML($html);
//      $mpdf->Output('periodo.pdf','F');
      $mpdf->Output();
      exit ();
   }
}

