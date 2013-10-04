<?php

class Cargo_Form_Cargo extends Cargo_Form_Formdecorator {

    public function init()
    {
        $this->setName('teste');
        $this->setAttrib('class', 'zend_form form-horizontal');
        $this->setMethod('POST');

        /* ***********************
         *  Criação dos elementos
         * ******************* */

        $nome = new Zend_Form_Element_Text('car_codigo');
        $nome->setLabel('Código:')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');
        $this->addElement($nome);
        //definindo a posição do elemento no formulário
        $this->configurandoTamanho('car_codigo', 'span8');
        //definindo o grupo que o elemento pertencerá
        //$this->montandoGrupo(array(''), 'grupo1');

        $nome = new Zend_Form_Element_Text('car_descricao');
        $nome->setLabel('Descrição:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe a descrição');
        $this->addElement($nome);
        //definindo a posição do elemento no formulário
        $this->configurandoTamanho('car_descricao', 'span8');
        //definindo o grupo que o elemento pertencerá
        $this->montandoGrupo(array('car_codigo','car_descricao'), 'grupo1');

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

