<?php

class Cargo_CargoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // para acessar aki: /cargo/index/add
        $form = new Cargo_Form_Cargo(); //Default_Form_Post();
        $model = new Cargo_Model_Cargo; //Default_Model_Post;
        //$acl = new MyAcl_Form_MyAcl($user);
//        var_dump($acl);die;
        $id = $this->_getParam('id');
        if($this->_request->isPost()){

            if($form->isValid($this->_request->getPost())){

                $data = $form->getValues();
                if($id){
                    $where = $model->getAdapter()->quoteInto('car_codigo = ?',$id);
                    $model->update($data,$where);
                }else{
                    $model->insert($data);
                }

                $this->_redirect('/cargo');
            }

        }elseif($id){
            $data = $model->busca($id);
            if(is_array($data)){
                $form->setAction('/cargo/add/id/' . $id);
                $form->populate($data);
            }
        }

        $this->view->form = $form;
    }

    
}



