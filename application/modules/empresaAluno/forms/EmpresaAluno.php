<?php

class EmpresaAluno_Form_EmpresaAluno extends EmpresaAluno_Form_Formdecorator {

   public function init() {

      $emp_codigo = new Zend_Form_Element_Select('emp_codigo',
                      array('label' => '* Empresa:',
                          'class' => 'select3 borda-arredondada')
      );
      $empresas = new Empresa_Model_Empresa();
      $resultPos = $empresas->fetchAll()->toArray();
      $optionsPos = array();
      foreach ($resultPos as $value) {
         $optionsPos[$value['emp_codigo']] = $value['emp_descricao'];
      }
      $emp_codigo->setMultiOptions($optionsPos);
      $emp_codigo->setRequired(true);
      $this->addElement($emp_codigo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('emp_codigo', 'span3');
      //definindo o grupo que o elemento pertencerá

      $db = Zend_Db_Table::getDefaultAdapter();
//      Lista de Alunos Cadastrados
      $alunos_cadastrados = new Aluno_Model_Aluno();
      $alunos_cadastrados = $db->fetchAll('SELECT alu_codigo, alu_nome FROM aluno');
//      Lista de Alunos na Empresa Escolhida
      $alunosEmpresa = new EmpresaAluno_Model_EmpresaAluno();
      $alunos_na_empresa = $db->fetchAll('SELECT alu_codigo FROM aluno_empresa where emp_codigo = ?', 16);
      // para usar o comando array_diff_assoc(tabela1,tabela2) precisamos de um array de cod_aluno
      $alunos_nao_cadastrados_na_empresa = array_diff_assoc($alunos_cadastrados, $alunos_na_empresa);
      $indice = key($alunos_nao_cadastrados_na_empresa);
      $alu_codigo = new Zend_Form_Element_Select('alu_codigo',
                      array('label' => '* Aluno:',
                            'class' => 'select3 borda-arredondada')
      );
      $alunos = new Aluno_Model_Aluno();
      $resultPos = $alunos->fetchAll()->toArray();
      $optionsPos = array();
      foreach ($resultPos as $value) {
         $optionsPos[$value['alu_codigo']] = $value['alu_nome'];
      }
      $alu_codigo->setMultiOptions($optionsPos);
      $alu_codigo->setRequired(true);
      $this->addElement($alu_codigo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('alu_codigo', 'span3');

      $ae_cargo = new Zend_Form_Element_Radio("ae_cargo");
      $ae_cargo->setLabel("Acesso? *")
              ->setValue('Operador')
              ->setAttrib('title', 'Informe o Cargo');
      $ae_cargo->addMultiOption('Administrador', 'Administrador');
      $ae_cargo->addMultiOption('Operador', 'Operador');
      $this->addElement($ae_cargo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('ae_cargo', 'span3');

      $ae_obs = new Zend_Form_Element_Textarea("ae_obs");
      $ae_obs->setLabel('Obs:')
              ->setAttrib('title', 'Digite uma observação');
      $this->addElement($ae_obs);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('ae_obs', 'span3');

      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array(
          'emp_codigo',
          'alu_codigo',
          'ae_cargo',
          'ae_obs'
              ), 'grupo1');


//      $ae_salario = new Zend_Form_Element_Text("ae_salario");
//      $ae_salario->setLabel('Salário:')
//              ->setAttrib('title', 'Informe o Salário');
//      $this->addElement($ae_salario);
//      //definindo a posição do elemento no formulário
//      $this->configurandoTamanho('ae_salario', 'span3');

      //definindo o grupo que o elemento pertencerá
//      $this->montandoGrupo(array(
//          'ae_cargo',
//          'ae_salario',
//          'ae_obs',
//              ), 'grupo2');

      $submit = new Zend_Form_Element_Submit('submit');
      $submit->setLabel('Salvar')
              ->setAttrib('class', 'btn btn-large btn-primary');
      $this->addElement($submit);

      $limpar = new Zend_Form_Element_Reset('limpar');
      $limpar->setLabel('Limpar')
              ->setAttrib('class', 'btn')
              ->setIgnore(true);
      $this->addElement($limpar);

      $this->montandoGrupo(array('submit', 'limpar'), 'botoes');

      $this->setAction('/empresaAluno/index/add')
              ->setMethod('post');
   }

}