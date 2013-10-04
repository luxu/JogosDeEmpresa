<?php

class Default_Form_correio extends Zend_Dojo_Form {

   public function init() {
      $this->setAction('/curso/index/add')
             ->setMethod('post');

      $zipcode = new Zend_Form_Element_Text("zipcode");
      $zipcode->setLabel("CEP");

      $ok = new Zend_Form_Element_Button("ok");
      $ok->setLabel("OK");


      $this->addElements(array(
            $zipcode,
            $ok,
        ));
   }
}