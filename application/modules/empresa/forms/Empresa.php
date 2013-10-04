<?php

class Empresa_Form_Empresa extends Empresa_Form_Formdecorator {

   public function init() {

      $this->setAction('/empresa/index/add')
              ->setMethod('post');

      $emp_descricao = new Zend_Form_Element_Text('emp_descricao');
      $emp_descricao->setLabel('Descrição: *')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->setDecorators(array(
                  'DijitElement',
                  'Errors',
                  'Label',
              ));
      $this->addElement($emp_descricao);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('emp_descricao', 'span3');
      //definindo o grupo que o elemento pertencerá

      $emp_data = new Zend_Form_Element_Text('emp_data');
      $emp_data->setLabel('Data:');
      $this->addElement($emp_data);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('emp_data', 'span3');
      //definindo o grupo que o elemento pertencerá

      $emp_ativa = new Zend_Form_Element_Radio('emp_ativa');
      $emp_ativa->setLabel('Empresa está ativa?')
              ->setValue('S')
              ->addMultiOptions(
                      array(
                          'S' => 'Sim',
                          'N' => 'Não',
                      )
      );
      $this->addElement($emp_ativa);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('emp_ativa', 'span3');
      //definindo o grupo que o elemento pertencerá

      $this->montandoGrupo(array(
          'emp_descricao',
          'emp_data',
          'emp_ativa',
          'emp_ativa'
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

