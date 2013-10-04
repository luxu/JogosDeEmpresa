<?php

class JogoEmpresa_jogoempresaController extends Zend_Controller_Action {

    public function init() {
        
    }

    // Action para exibir o grid
    public function indexAction() {
//             var_dump($this->_request);die;
           // Nada
    }

    // Action para fornecer os dados do grid
    public function dadosAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        //$limit = 10; 
        $limit = $this->_request->getParam("rows");
        $sidx = $this->_request->getParam("sidx", 1);
        $sord = $this->_request->getParam("sord");

        //var_dump($this->_request->getParam("sord"));die;
        
        $tabela = new JogoEmpresa_Model_JogoEmpresa();
        $jogoEmpresa = $tabela->fetchAll();

        $count = count($jogoEmpresa);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        //$jogoEmpresa = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page*$limit-$limit));
        $jogoEmpresa = $tabela->fetchAll(null, $sord, $limit, ($page * $limit - $limit));

        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;

        foreach ($jogoEmpresa as $row) {
            $responce->rows[$i]['emp_codigo'] = $row->emp_codigo;
            $responce->rows[$i]['cell'] = array(
                $row->emp_codigo,
                $row->jog_codigo,
                $row->empjog_notafinal,
                $row->empjog_classificacao,
                $row->empjog_estado
            );
            $i++;
        }

        $this->view->dados = $responce;
        //echo json_encode($responce);
    }

    // Action para adicionar, editar ou deletar os registros da agenda
    public function saveAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $tabela = new JogoEmpresa_Model_JogoEmpresa();
        $oper = $this->_request->getPost("oper");

        if ($oper == "edit" || $oper == "del") {
            $id = $this->_request->getPost("emp_codigo");
            $jogoEmpresa = $tabela->find($id)->current();
        } else {
            $jogoEmpresa = $tabela->fetchNew();
        }

        if ($oper == "add" || $oper == "edit") {
            $jogoEmpresa->emp_codigo = $this->_request->getPost("emp_codigo");
            $jogoEmpresa->jog_codigo = $this->_request->getPost("jog_codigo");
            $jogoEmpresa->empjog_notafinal = $this->_request->getPost("empjog_notafinal");
            $jogoEmpresa->save();
        } elseif ($oper == "del") {
            $jogoEmpresa->delete();
        }
    }

}

