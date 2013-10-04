<?php

class JogoEmpresa_Form_JogoEmpresa extends JogoEmpresa_Form_Formdecorator {

   public function init() {

      $this->setAction('/jogoEmpresa/index/add')
           ->setMethod('post');

      $jog_codigo = new Zend_Form_Element_Select('jog_codigo',
                      array('label' => '* Jogo:',
                          'class' => 'select3 borda-arredondada')
                             );
      $jogos = new Jogo_Model_Jogo();
      $resultPos = $jogos->fetchAll()->toArray();
      $optionsPos = array();
      foreach ($resultPos as $value) {
         $optionsPos[$value['jog_codigo']] = $value['jog_tema'];
      }
      $jog_codigo->setMultiOptions($optionsPos);
      $this->addElement($jog_codigo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_codigo', 'span3');

      $empjog_notafinal = new Zend_Form_Element_Text('empjog_notafinal');
      $empjog_notafinal->setLabel('Nota Final:');
      $this->addElement($empjog_notafinal);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('empjog_notafinal', 'span3');

      $empjog_classificacao = new Zend_Form_Element_Text('empjog_classificacao');
      $empjog_classificacao->setLabel('Classificação:');
      $this->addElement($empjog_classificacao);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('empjog_classificacao', 'span3');

      $empjog_estado = new Zend_Form_Element_Radio("empjog_estado");
      $empjog_estado->setLabel('Estado:')
              ->addMultiOptions(array('Ativa' => 'Ativa',
                  'Inativa' => 'Inativa'
                      )
              )
              ->setValue('Ativa')
              ->setAttrib('title', 'Informe o Estado');
      $this->addElement($empjog_estado);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('empjog_estado', 'span3');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array(
          'jog_codigo',
          'empjog_notafinal',
          'empjog_classificacao',
          'empjog_estado'
          ),'grupo1');

      $db = Zend_Db_Table::getDefaultAdapter();
//      Lista de Empresas Cadastradas
      $empresas_cadastrados = new EmpresaAluno_Model_EmpresaAluno();
      $empresas_cadastrados = $db->fetchAll('SELECT emp_codigo, emp_descricao FROM empresa'); // ORDER BY alu_codigo ASC , alu_nome
//    Lista de Empresas do Jogo Escolhido
      $jogoEmpresas = new JogoEmpresa_Model_JogoEmpresa();
      $empresas_no_jogo = $db->fetchAll('SELECT jog_codigo FROM empresa_jogo where emp_codigo = ?', 1);
      $empresas_nao_cadastradas_no_jogo = array_diff_assoc($empresas_cadastrados, $empresas_no_jogo);
      $indice = key($empresas_nao_cadastradas_no_jogo);

      $emp_codigo = new Zend_Form_Element_Select('emp_codigo',
                      array('label' => '* Empresa:',
                          'class' => 'select3 borda-arredondada')
              );
      $empresas = new Empresa_Model_Empresa;
      $resultPos = $empresas->fetchAll()->toArray();
      $optionsPos = array();
      foreach ($resultPos as $value) {
         $optionsPos[$value['emp_codigo']] = $value['emp_descricao'];
      }
      $emp_codigo->setMultiOptions($optionsPos);
      //definindo o grupo que o elemento pertencerá
      $this->addElement($emp_codigo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('emp_codigo', 'span3');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array(
          'emp_codigo'
          ),'grupo2');

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
   }
}

