<?php

class Curso_Form_Curso extends Curso_Form_Formdecorator {

   public function init() {
      $cur_descricao = new Zend_Form_Element_Text('cur_descricao');
      $cur_descricao->setLabel('Descrição do curso:')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->addFilter('StripTags')
              ->setAttrib('style', 'width:340px');

      $this->addElement($cur_descricao);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('cur_descricao', 'span3');
      //definindo o grupo que o elemento pertencerá

      $submit = new Zend_Form_Element_Submit('submit');
      $submit->setLabel('Salvar')
              ->setAttrib('class', 'btn btn-large btn-primary');
      $this->addElement($submit);

      $limpar = new Zend_Form_Element_Reset('limpar');
      $limpar->setLabel('Limpar')
              ->setAttrib('class', 'btn btn-large btn-primary')
              ->setIgnore(true);
      $this->addElement($limpar);

      $this->montandoGrupo(array('submit', 'limpar'), 'botoes');

      $this->setAction('/curso/index/add')
              ->setMethod('post');
   }

}
