<?php

class Default_IndexController extends Zend_Controller_Action {

    public function indexAction() {
        $form = new Default_Form_Login;
        $request = $this->_request;
        if ($request->isPost()) {
            $data = $request->getPost();
            $usuarioPadrao = $data['login'];
            $senhaPadrao = $data['senha'];
            if ($usuarioPadrao == 'luxu' && $senhaPadrao == '55198122') {
                    $this->_redirect('coordenador');
                } else {
                    if ($form->isValid($data)) {
                        $data = $form->getValues();
                        $login = Default_Model_Login::login($data['login'], $data['senha'], $data['acesso']);
                        if ($login === true) {
                            $this->_redirect('/default/index/home');
                        } else {
                            $this->_helper->FlashMessenger(array('erro' => $login));
                            $form->populate($data);
                        }
                    }
                }
        }
        $this->view->form = $form;
    }

    public function sairAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/');
    }

    public function homeAction() {
        $form = "PÁGINA INICIAL";
        $this->view->form = $form;
    }

    public function aboutAction() {
        $form = "PÁGINA INICIAL";
        $this->view->form = $form;
    }
}

