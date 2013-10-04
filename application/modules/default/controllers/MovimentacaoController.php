<?php

class Default_MovimentacaoController extends Zend_Controller_Action {

   public function indexAction() {

   }

   public function sairAction() {

   }

   public function homeAction() {

   }

   public function aboutAction() {

   }

   public function correioAction() {
      $form = new Default_Form_correio();

      $this->view->form = $form;
   }

   public function lerjornalAction() {
      $jornal = new Jornal_Model_Jornal();
      $form = new Default_Form_lerjornal();
      $id = $this->_getParam('jor_codigo');
      if ($this->_request->isPost()) {
         if ($form->isValid($this->_request->getPost())) {
//            $data = $form->getValues();
            $row = $jornal->busca($id);
            $this->view->data = $row;
         }
      } else {
         $this->view->form = $form;
      }
   }

}

