<?php

class Periodo_Form_Periodo extends Periodo_Form_Formdecorator {

   public function init() {
      $this->setAction('/periodo/index/add')
              ->setMethod('post');

      /*       * ***********************
       *  Criação dos elementos *
       * ********************** */

      $usuario = Zend_Auth::getInstance()->getStorage()->read();

      $alu_codigo = new Zend_Form_Element_Hidden('alu_codigo');
      $alu_codigo->setValue($usuario->alu_codigo)
              ->setDecorators(array('ViewHelper'))
      ;
      $this->addElement($alu_codigo);

      $aluno_empresa = new EmpresaAluno_Model_EmpresaAluno();
      if (isset($usuario->alu_codigo)) {
         $empresa_jogo = new JogoEmpresa_Model_JogoEmpresa();
         $jogo = new Jogo_Model_Jogo();
         $periodo = new Periodo_Model_Periodo();
         $codigoEmpresa = $aluno_empresa->fetchRow("alu_codigo = " . $usuario->alu_codigo);
         // até aki tenho o CODIGO DA EMPRESA E DO ALUNO
         $informacoesPeriodo = $periodo
                         ->fetchRow("emp_codigo = " . $codigoEmpresa->emp_codigo . " AND alu_codigo = " . $usuario->alu_codigo);
         // testa se o aluno num tem nenhum período salvo aparecerá 1 caso contrário somará 1 no q está
         if ($informacoesPeriodo == null) {
            $periodo = 1;
            // o capital inicial será no primeiro período vindo da tabela JOGO
            $jogo = new JogoEmpresa_Model_JogoEmpresa();
            $jg = $jogo->fetchRow("emp_codigo = " . $codigoEmpresa->emp_codigo);
            $jogo = new Jogo_Model_Jogo();
            $jg = $jogo->fetchRow("jog_codigo = " . $jg->jog_codigo);
            $capInicial = $jg->jog_capitalinicial;
            $funcionarioInicial = $jg->jog_qtdefuncionarios;
         } else {
            $periodo = $informacoesPeriodo->per_codigo + 1;
            $capInicial = $informacoesPeriodo->per_capitalfinalperiodo;
            $funcionarioInicial = $informacoesPeriodo->per_qtdefuncionariosfinal;
//            var_dump($informacoesPeriodo);die;
         }
      } else {
         $codigoEmpresa = $aluno_empresa->fetchAll();
         $periodo = "";
      }

      $per_codigo = new Zend_Form_Element_Text('per_codigo');
      $per_codigo->setLabel('Período:')
              ->setValue($periodo)
              ->setAttrib('style', 'width:40px')
              ->setAttrib('readonly', true)
      ;
      $this->addElement($per_codigo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('per_codigo', 'span1');
      //definindo o grupo que o elemento pertencerá

      if (isset($usuario->alu_codigo)) {
         $empr = new Empresa_Model_Empresa();
         $carregaEmpresa = $empr->find($codigoEmpresa->emp_codigo);
         $optionsPos = array();
         foreach ($carregaEmpresa as $value) {
            $optionsPos[$value['emp_codigo']] = $value['emp_descricao'];
         }
         $emp_codigo = new Zend_Form_Element_Select('emp_codigo',
                         array('label' => '* Empresa:', 
                              'style' => 'width:150px'));
         $emp_codigo->setMultiOptions($optionsPos)
                 ->setAttrib('readonly', true);
      } else {
         $emp_codigo = new Zend_Form_Element_Select('emp_codigo',
                         array('label' => '* Empresa:',
                              'style' => 'width:150px')
                 );
         $empresas = new Empresa_Model_Empresa();

         $resultPos = $empresas->fetchAll()->toArray();
         $optionsPos = array();
         foreach ($resultPos as $value) {
            $optionsPos[$value['emp_codigo']] = $value['emp_descricao'];
         }
         $emp_codigo->setMultiOptions($optionsPos);
         $emp_codigo->setRequired(true);
      }
      $this->addElement($emp_codigo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('emp_codigo', 'span2');

      $date = new Zend_Date();
      $data = $date->get(Zend_Date::DATE_MEDIUM, 'pt_BR');
      $date->sub('2', Zend_Date::HOUR);
      $hora = $date->get(Zend_Date::TIME_SHORT, 'pt_BR');

      $per_dataentrega = new Zend_Form_Element_Text('per_dataentrega');
      $per_dataentrega->setLabel('Data Entrega:')
              ->setAttrib('readonly', true)
              ->setAttrib('style', 'width:80px')
              ->setValue($data);
      $this->addElement($per_dataentrega);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('per_dataentrega', 'span2');

      $per_horaentrega = new Zend_Form_Element_Text('per_horaentrega');
      $per_horaentrega->setLabel('Hora Entrega:')
              ->setAttrib('readonly', true)
              ->setAttrib('style', 'width:70px')
              ->setValue($hora);
      $this->addElement($per_horaentrega);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('per_horaentrega', 'span2');
      $per_capitalinicialperiodo = new Zend_Form_Element_Text('per_capitalinicialperiodo');
      $per_capitalinicialperiodo->setLabel('Capital Inicial:')
              ->setAttrib('readonly', true)
              ->setValue($capInicial);
      $this->addElement($per_capitalinicialperiodo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('per_capitalinicialperiodo', 'span2');
      //definindo o grupo que o elemento pertencerá

      $per_qtdefuncionariosinicial = new Zend_Form_Element_Text('per_qtdefuncionariosinicial');
      $per_qtdefuncionariosinicial->setLabel('Qtde Func. Inicial')
              ->setAttrib('readonly', true)
              ->setValue($funcionarioInicial);
      $this->addElement($per_qtdefuncionariosinicial);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('per_qtdefuncionariosinicial', 'span2');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array(
          'per_codigo',
          'emp_codigo',
          'per_dataentrega',
          'per_horaentrega',
          'per_capitalinicialperiodo',
          'per_qtdefuncionariosinicial',
              ), 'grupo1');

//      $per_qtdefuncionariosfinal = new Zend_Form_Element_Text('per_qtdefuncionariosfinal');
//      $per_qtdefuncionariosfinal->setLabel('Qtde Funcionarios Final')->setValue(0);
//      $this->addElement($per_qtdefuncionariosfinal);
      //definindo a posição do elemento no formulário
//      $this->configurandoTamanho('per_qtdefuncionariosfinal', 'span3');
      //definindo o grupo que o elemento pertencerá

//      $per_vlgastopropaganda = new Zend_Form_Element_Text('per_vlgastopropaganda');
//      $per_vlgastopropaganda->setLabel('Valor Gasto Propaganda:')->setValue(0);
//      $this->addElement($per_vlgastopropaganda);
      //definindo a posição do elemento no formulário
//      $this->configurandoTamanho('per_vlgastopropaganda', 'span3');
      //definindo o grupo que o elemento pertencerá

      $per_qtdefuncionariosadmitidos = new Zend_Form_Element_Text('per_qtdefuncionariosadmitidos');
      $per_qtdefuncionariosadmitidos->setLabel('Admitidos:')->setValue(0);
      $this->addElement($per_qtdefuncionariosadmitidos);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('per_qtdefuncionariosadmitidos', 'span1');


      $per_qtdefuncionariosdemitidos = new Zend_Form_Element_Text('per_qtdefuncionariosdemitidos');
      $per_qtdefuncionariosdemitidos->setLabel('Demitidos:')->setValue(0);
      $this->addElement($per_qtdefuncionariosdemitidos);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('per_qtdefuncionariosdemitidos', 'span1');
      //definindo o grupo que o elemento pertencerá

      $per_vlgastotreinamento = new Zend_Form_Element_Text('per_vlgastotreinamento');
      $per_vlgastotreinamento->setLabel('Treinamento(%):')->setValue(0);
      $this->addElement($per_vlgastotreinamento);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('per_vlgastotreinamento', 'span1');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array(
          'per_qtdefuncionariosadmitidos',
          'per_qtdefuncionariosdemitidos',
          'per_vlgastotreinamento',
              ), 'grupo2');

//      $per_vlvendas = new Zend_Form_Element_Text('per_vlvendas');
//      $per_vlvendas->setLabel('Valor Vendas:')->setValue(0);
//      $this->addElement($per_vlvendas);
      //definindo a posição do elemento no formulário
//      $this->configurandoTamanho('per_vlvendas', 'span3');
      //definindo o grupo que o elemento pertencerá

//      $per_vlgastosalarios = new Zend_Form_Element_Text('per_vlgastosalarios');
//      $per_vlgastosalarios->setLabel('Valor Gasto Salário:')->setValue(0);
//      $this->addElement($per_vlgastosalarios);
      //definindo a posição do elemento no formulário
//      $this->configurandoTamanho('per_vlgastosalarios', 'span3');
      //definindo o grupo que o elemento pertencerá

//      $per_vlgastodemissao = new Zend_Form_Element_Text('per_vlgastodemissao');
//      $per_vlgastodemissao->setLabel('Valor Gasto Demissão:')->setValue(0);
//      $this->addElement($per_vlgastodemissao);
      //definindo a posição do elemento no formulário
//      $this->configurandoTamanho('per_vlgastodemissao', 'span3');

      
//      $this->montandoGrupo(array(
//          'per_vlvendas',
//          'per_vlgastosalarios',
//          'per_vlgastodemissao',

//              ), 'grupo3');

      //definindo o grupo que o elemento pertencerá

//      $per_capitalfinalperiodo = new Zend_Form_Element_Text('per_capitalfinalperiodo');
//      $per_capitalfinalperiodo->setLabel('Capital Final do periodo:')->setValue(0);
//      $this->addElement($per_capitalfinalperiodo);
      //definindo a posição do elemento no formulário
//      $this->configurandoTamanho('per_capitalfinalperiodo', 'span3');
//      $this->montandoGrupo(array(
//
//          'per_capitalfinalperiodo',
//          ),'grupo4');

      $submit = new Zend_Form_Element_Submit('submit');
      $submit->setLabel('Salvar')
              ->setAttrib('class', 'btn btn-large btn-primary')
              ->setIgnore(true);
      $this->addElement($submit);

      $limpar = new Zend_Form_Element_Reset('limpar');
      $limpar->setLabel('Limpar')
              ->setAttrib('class', 'btn')
              ->setIgnore(true);
      $this->addElement($limpar);

      $this->montandoGrupo(array('submit', 'limpar'), 'botoes');
   }

}