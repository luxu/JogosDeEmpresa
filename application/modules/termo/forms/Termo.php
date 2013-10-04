<?php

class Termo_Form_Termo extends Termo_Form_Formdecorator {

    public function init() {
        $this->setAction('/termo/index/add')
                ->setMethod('post');

      $ter_descricao = new Zend_Form_Element_Text('ter_descricao');
      $ter_descricao->setLabel('Descrição do Termo:')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->addFilter('StripTags')
              ->setAttrib('style', 'width:340px');
      $this->addElement($ter_descricao);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('ter_descricao', 'span3');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array('ter_descricao'), 'grupo1');

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

