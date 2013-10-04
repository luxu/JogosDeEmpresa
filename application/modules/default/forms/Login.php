<?php

class Default_Form_Login extends Default_Form_Formdecorator {

   public function init() {

      $this->setAttrib('class', 'zend_form form-horizontal');
      $this->setMethod('post');

      $acesso = new Zend_Form_Element_Select('acesso');
      $acesso->setLabel('Acesso:')
              //->addMultiOption('', '')
              ->addMultiOption('Coordenador', 'Coordenador')
              ->addMultiOption('Aluno', 'Aluno');
      $this->addElement($acesso);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('acesso', 'span8');

      $login = new Zend_Form_Element_Text('login');
      $login->setLabel('Login/RA:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')// tira o espaço em branco da string
              ->addValidator('NotEmpty')
              ->setAttrib('placeholder','Login')
              ->setAttrib('title', 'Digite o login');
      $this->addElement($login);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('login', 'span8');

      $senha = new Zend_Form_Element_Password('senha');
      $senha->setLabel('Senha:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')// tira o espaço em branco da string
              ->setAttrib('placeholder','Senha')
              ->setAttrib('title', 'Digite a senha')
              ->addValidator('NotEmpty');
      $this->addElement($senha);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('senha', 'span8');

      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array(
          'acesso',
          'login',
          'senha',
              ), 'grupo1');

      $submit = new Zend_Form_Element_Submit('submit');
      $submit->setLabel('Acessar')
              ->setAttrib('class', 'btn btn-large btn-primary')
              ->setIgnore(true);
      $this->addElement($submit);

      $limpar = new Zend_Form_Element_Reset('limpar');
      $limpar->setLabel('Limpar')
              ->setAttrib('class', 'btn')
              ->setIgnore(true);
      $this->addElement($limpar);

      //os botões por padrão ficarão sempre centralizados desde que façam parte do grupo botoes
      $this->montandoGrupo(array('submit', 'limpar', ), 'botoes');
   }

}