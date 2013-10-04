<?php

class Produto_Form_Produto extends Produto_Form_Formdecorator {

    public function init() {
        $this->setAction('/produto/index/add');
        // Criando os elementos

        $compras = new Zend_Form_Element_Text('pro_compras');
        $compras->setLabel('Compras:')
                ->addValidator('regex', false, array('/^[1-9]+/'));
        $this->addElement($compras);
        $this->configurandoTamanho('pro_compras', 'span8');

        $prazopagto = new Zend_Form_Element_Text('pro_prazopagto');
        $prazopagto->setLabel('Prazo de Pagamento:')
                ->addValidator('regex', false, array('/^[1-9]+/'));
        $this->addElement($prazopagto);
        $this->configurandoTamanho('pro_prazopagto', 'span8');

        $precovenda = new Zend_Form_Element_Text('pro_precovenda');
        $precovenda->setLabel('Preço de venda:')
                ->addValidator('regex', false, array('/^[1-9]+/'));
        $this->addElement($precovenda);
        $this->configurandoTamanho('pro_precovenda', 'span8');

        $prazorecebimento = new Zend_Form_Element_Text('pro_prazorecebimento');
        $prazorecebimento->setLabel('Prazo de Recebimento:')
                ->addValidator('regex', false, array('/^[1-9]+/'));
        $this->addElement($prazorecebimento);
        $this->configurandoTamanho('pro_prazorecebimento', 'span8');

        $propaganda = new Zend_Form_Element_Text('pro_propaganda');
        $propaganda->setLabel('Propaganda:')
                ->addValidator('regex', false, array('/^[1-9]+/'));
        $this->addElement($propaganda);
        $this->configurandoTamanho('pro_propaganda', 'span8');

        $tipo = new Zend_Form_Element_Text('pro_tipo');
        $tipo->setLabel('Tipo:')
                ->addValidator('regex', false, array('/^[1-9]+/'));
        $this->addElement($tipo);
        $this->configurandoTamanho('pro_tipo', 'span8');

        // monta o fieldset e agrupa os campos criados acima
        $this->montandoGrupo(array(
            'pro_compras',
            'pro_prazopagto',
            'pro_precovenda',
            'pro_prazorecebimento',
            'pro_propaganda',
            'pro_tipo'
            ),'agruparProdutos');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Salvar')
                ->setAttrib('class', 'btn btn-large btn-primary')
                ->setIgnore(true);
        $this->addElement($submit);

        $limpar = new Zend_Form_Element_Reset('limpar');
        $limpar->setLabel('Limpar')
                ->setAttrib('class', 'btn btn-large btn-warning')
                ->setIgnore(true);
        $this->addElement($limpar);

        //os botões por padrão ficarão sempre centralizados desde que façam parte do grupo botoes
        $this->montandoGrupo(array('submit', 'limpar'), 'botoes');
    }

}

