<?php

class Default_Form_lerjornal extends Default_Form_Formdecorator {

   public function init() {

      $this->setAction('/default/movimentacao/lerjornal/id')
              ->setMethod('post');

      $jor_codigo = new Zend_Form_Element_Select('jor_codigo',
                      array('label' => '* Jornal:',
                          'class' => 'select3 borda-arredondada')
      );
      $jornais = new Jornal_Model_Jornal();
      $resultPos = $jornais->fetchAll()->toArray();
      $optionsPos = array();
      foreach ($resultPos as $value) {
         $date = new Zend_Date($value['jor_datapublicacao']);
         $optionsPos[$value['jor_codigo']] = $date->get(Zend_Date::DATE_SHORT, 'pt_BR');
      }
      $jor_codigo->setMultiOptions($optionsPos);
      $jor_codigo->setRequired(true);
      $this->addElement($jor_codigo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('jor_codigo', 'span3');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array(
          'jor_codigo',
              ), 'grupo1');

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