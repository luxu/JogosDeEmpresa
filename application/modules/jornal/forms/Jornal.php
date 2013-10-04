<?php

class Jornal_Form_Jornal extends Jornal_Form_Formdecorator {

   public function init() {

      $this->setAction('/jornal/index/add')
              ->setMethod('post');

      $jor_datapublicacao = new Zend_Form_Element_Text('jor_datapublicacao');
      $jor_datapublicacao->setLabel('Publicado em: *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o Dt Publicação');
      $this->addElement($jor_datapublicacao);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jor_datapublicacao', 'span3');
      //definindo o grupo que o elemento pertencerá

      $jor_dolar = new Zend_Form_Element_Text('jor_dolar');
      $jor_dolar->setLabel('Dolar: *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o Dolar');
      $this->addElement($jor_dolar);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jor_dolar', 'span3');
      //definindo o grupo que o elemento pertencerá

      $jor_precocusto = new Zend_Form_Element_Text('jor_precocusto');
      $jor_precocusto->setLabel('Preço de custo: *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o Preço de custo');
      $this->addElement($jor_precocusto);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jor_precocusto', 'span3');

      $jor_nrofuncionario = new Zend_Form_Element_Text('jor_nrofuncionario');
      $jor_nrofuncionario->setLabel('Nro de Funcionário: *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o Nro de Funcionário');
      $this->addElement($jor_nrofuncionario);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jor_nrofuncionario', 'span3');
      //definindo o grupo que o elemento pertencerá

      $jor_cotamarketing = new Zend_Form_Element_Text('jor_cotamarketing');
      $jor_cotamarketing->setLabel('Marketing: *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o Marketing');
      $this->addElement($jor_cotamarketing);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jor_cotamarketing', 'span3');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array(
          'jor_datapublicacao',
          'jor_dolar',
          'jor_precocusto',
          'jor_nrofuncionario',
          'jor_cotamarketing'
              ), 'grupo3');

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

