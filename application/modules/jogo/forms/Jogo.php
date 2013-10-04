<?php

class Jogo_Form_Jogo extends Jogo_Form_Formdecorator {

   public function init() {
      $this->setAction('/jogo/index/add')
              ->setMethod('post');

      $jog_ano = new Zend_Form_Element_Text('jog_ano');
      $jog_ano->setLabel('Ano do jogo: *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o Ano do Jogo');
      $this->addElement($jog_ano);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_ano', 'span3');

      $jog_capitalinicial = new Zend_Form_Element_Text('jog_capitalinicial');
      $jog_capitalinicial->setLabel('Capital Inicial: *')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o Capital Inicial');
      $this->addElement($jog_capitalinicial);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_capitalinicial', 'span3');

      $jog_inicio = new Zend_Form_Element_Text('jog_inicio');
      $jog_inicio->setLabel('Inicio do jogo: *')
              ->setRequired(true)
              ->addValidator('NotEmpty')
//              ->setValue(date('Y-m-d'))
              ->setAttrib('title', 'Informe a Data de Inicio');
      $this->addElement($jog_inicio);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_inicio', 'span3');

      $jog_termino = new Zend_Form_Element_Text('jog_termino');
      $jog_termino->setLabel('Termino do jogo:')
              ->setAttrib('title', 'Informe a Data de Término');
      $this->addElement($jog_termino);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_termino', 'span3');

      $jog_tema = new Zend_Form_Element_Text('jog_tema');
      $jog_tema->setLabel('Tema: *')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o Tema para o Jogo');
      $this->addElement($jog_tema);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_tema', 'span3');


      $jog_precoprod_a = new Zend_Form_Element_Text('jog_precoprod_a');
      $jog_precoprod_a->setLabel('Preço Produto A: *')
              ->setRequired(true)
              ->setAttrib('title', 'Informe a Preço do Produto A');
      $this->addElement($jog_precoprod_a);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_precoprod_a', 'span3');

      $jog_precoprod_b = new Zend_Form_Element_Text('jog_precoprod_b');
      $jog_precoprod_b->setLabel('Preço Produto B: *')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe a Preço do Produto B');
      $this->addElement($jog_precoprod_b);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_precoprod_b', 'span3');

      $jog_precoprod_c = new Zend_Form_Element_Text('jog_precoprod_c');
      $jog_precoprod_c->setLabel('Preço Produto C: *')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe a Preço do Produto C');
      $this->addElement($jog_precoprod_c);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_precoprod_c', 'span3');

      $jog_precoprod_d = new Zend_Form_Element_Text('jog_precoprod_d');
      $jog_precoprod_d->setLabel('Preço Produto D: *')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe a Preço do Produto C');
      $this->addElement($jog_precoprod_d);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_precoprod_d', 'span3');

      $jog_precoprod_e = new Zend_Form_Element_Text('jog_precoprod_e');
      $jog_precoprod_e->setLabel('Preço Produto E: *')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe a Preço do Produto D');
      $this->addElement($jog_precoprod_e);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_precoprod_e', 'span3');

      $jog_qtdefuncionarios = new Zend_Form_Element_Text('jog_qtdefuncionarios');
      $jog_qtdefuncionarios->setLabel('Quantidade de funcionários: *')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe a Preço do Produto E');
      $this->addElement($jog_qtdefuncionarios);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jog_qtdefuncionarios', 'span3');
      //definindo o grupo que o elemento pertencerá
      /*       * ************************************Grupos************************************ */
      $this->montandoGrupo(array(
          'jog_ano',
          'jog_capitalinicial',
          'jog_inicio',
          'jog_termino',
          'jog_tema',
          'jog_precoprod_a',
          'jog_precoprod_b',
          'jog_precoprod_c',
          'jog_precoprod_d',
          'jog_precoprod_e',
          'jog_qtdefuncionarios'
              ), 'grupo3');
      /*       * ************************************Fim do Grupo******************************* */
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

