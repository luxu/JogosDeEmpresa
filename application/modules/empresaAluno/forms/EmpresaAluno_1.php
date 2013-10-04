<?php

class EmpresaAluno_Form_EmpresaAluno extends Zend_Dojo_Form {

   public function init() {
      
      $this->setAction('/empresaAluno/index/add')
           ->setMethod('post');

      $emp_codigo = new Zend_Dojo_Form_Element_FilteringSelect('emp_codigo');
      $emp_codigo->setLabel('Empresa: *')
              ->setRequired(true);
      $empresas = new Empresa_Model_Empresa;
      $emp_codigo->addMultiOption('','Escolha a Empresa');
      foreach ($empresas->fetchAll() as $emp) {
         $valor = $emp->emp_codigo . " - " . $emp->emp_descricao;
         $emp_codigo->addMultiOption($emp->emp_codigo, $valor);
      }

      $ae_cargo = new Zend_Dojo_Form_Element_RadioButton("ae_cargo");
      $ae_cargo->setLabel('Cargo:')
              ->addMultiOptions(array('Administrador' => 'Administrador',
                                      'Operador' => 'Operador'
                                      )
                                )
              ->setValue('Operador')
              ->setAttrib('title', 'Informe o Cargo');

      $ae_salario = new Zend_Dojo_Form_Element_CurrencyTextBox("ae_salario");
      $ae_salario->setLabel('Salário:')
                 ->setRequired(false)
                 ->setAttrib('title', 'Informe o Salário');

      $ae_obs = new Zend_Form_Element_Textarea("ae_obs");
      $ae_obs->setLabel('Obs:')
              ->setAttrib('title', 'Digite uma observação');

      $db = Zend_Db_Table::getDefaultAdapter();
//      Lista de Alunos Cadastrados
      $alunos_cadastrados = new Aluno_Model_Aluno();
      $alunos_cadastrados = $db->fetchAll('SELECT alu_codigo, alu_nome FROM aluno'); // ORDER BY alu_codigo ASC , alu_nome
//      Lista de Alunos na Empresa Escolhida
      $alunosEmpresa = new EmpresaAluno_Model_EmpresaAluno();
      $alunos_na_empresa = $db->fetchAll('SELECT alu_codigo FROM aluno_empresa where emp_codigo = ?',1);
      $alunos_nao_cadastrados_na_empresa = array_diff_assoc($alunos_cadastrados,$alunos_na_empresa);
      $indice = key($alunos_nao_cadastrados_na_empresa);

      $aluno = new Zend_Dojo_Form_Element_FilteringSelect('alu_codigo');
      $aluno->setLabel('Escolha o aluno')
            ->setRequired(true);
      $aluno->addMultiOption('','Escolha o aluno');
      foreach ($alunos_nao_cadastrados_na_empresa as $alunos) {
      $aluno->addMultiOption($alunos['alu_codigo'],
                 $alunos["alu_codigo"] . "-"
                 . $alunos["alu_nome"]);
      }
      
//      $subForm = new Zend_Form_SubForm();
//      $inserir = new Zend_Form_Element_Button('inserir'); //Dojo_Form_Element_Button('inserir');
//      $inserir->setLabel('Inserir')->setIgnore(true);

//      $txtEmpresa =  new Zend_Dojo_Form_Element_TextBox('txtEmpresa');
//      $txtEmpresa->setLabel('TXTEmpresa');

//      $db = Zend_Db_Table::getDefaultAdapter();
//      $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
//      if ($id > 0) {
//         $empresa_tem_alunos = $db->fetchAll('SELECT a.alu_codigo, a.alu_nome FROM aluno_empresa ae, aluno a
//            where ae.alu_codigo = a.alu_codigo AND emp_codigo = ' . $id);
//         $alunos_empresas = new JogoEmpresa_Model_JogoEmpresa();
//         $alunos_empresas = $db->fetchAll('SELECT ae.alu_codigo, a.alu_nome FROM aluno_empresa as ae,
//           aluno as a where a.alu_codigo = ae.alu_codigo');
//         foreach ($empresa_tem_alunos as $row) {
//            $id = $row['alu_codigo'];
//            $nome = $row['alu_nome'];
//            $rowForm = new Zend_Form_SubForm('rowForm');
//            $rowForm->addElement('text', $id,
//                    array('value' => $nome,)
//            );
//            $rowForm->setElementDecorators(array('ViewHelper', 'Errors',array('HtmlTag',),));
//            $subForm->addSubForm($rowForm, $id);
//         }
//      }
//      $subForm->setSubFormDecorators(array('FormElements',array('HtmlTag',array('tag' => 'tr')),));
      $this->addElement('submit', 'submit', array('label' => "Cadastrar",'decorators' => array('ViewHelper'),));
      $this->addElement('submit', 'limpar', array('label' => "Limpar",'ignore' => "true",'decorators' => array('ViewHelper'),));

      /* -----------------------FIELDSET's----------------------------------- */

      $this->addElements(array($emp_codigo,$ae_cargo,$ae_salario,$ae_obs,$aluno));
//      $this->addDisplayGroup(array($aluno), 'alunos',
//              array("legend" => "Alunos para Empresa","style" => "border:1px solid black; padding: 5px;"),
//              array('decorators' =>array('FormElements',array('HtmlTag', array('tag' => 'table', 'class' => 'classTabela')),'DtDdWrapper')))
//           ->setSubFormDecorators(array('FormElements',array('HtmlTag',array('tag' => 'tbody')),));

      $this->addDisplayGroup(array('submit', 'limpar'), 'botoes',
              array("style" => "border:1px solid black; padding: 5px; width: 150px; height:30px;"),
              array(array('data'=>'HtmlTag'),array('tag'=>'table', 'width'=>'100%', 'cellspacing' => '2', 'cellpadding'=>'2','tag'=>'b')),'Form',
              array('decorators' => array('FormElements',array('HtmlTag', array('tag' => 'div', 'class' => 'buttons')),'DtDdWrapper')));

  }
}