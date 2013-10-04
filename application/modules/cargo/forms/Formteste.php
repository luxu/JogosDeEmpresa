<?php

class Academico_Form_Formteste extends Academico_Form_Formdecorator {

    public function init() {
        $this->setName('teste');
        $this->setAttrib('class', 'zend_form form-horizontal');
        $this->setMethod('POST');

        /* ***********************
         *  Criação dos elementos
         * ******************* */

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o nome');
        $this->addElement($nome);
        //definindo a posição do elemento no formulário
        $this->configurandoTamanho('nome', 'span8');
        //definindo o grupo que o elemento pertencerá
        $this->montandoGrupo(array('nome'), 'grupo1');


        $sobrenome = new Zend_Form_Element_Text('sobrenome');
        $sobrenome->setLabel('Sobrenome:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o sobrenome');
        $this->addElement($sobrenome);
        //definindo a posição do elemento no formulário
        $this->configurandoTamanho('sobrenome', 'span3');

        $rg = new Zend_Form_Element_Text('rg');
        $rg->setLabel('RG:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o rg');
        $this->addElement($rg);
        //definindo a posição do elemento no formulário
        $this->configurandoTamanho('rg', 'span3');

        $cpf = new Zend_Form_Element_Text('cpf');
        $cpf->setLabel('CPF:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o cpf');
        $this->addElement($cpf);
        //definindo a posição do elemento no formulário
        $this->configurandoTamanho('cpf', 'span3');
        //definindo o grupo que os elementos pertencerão
        $this->montandoGrupo(array('sobrenome', 'rg', 'cpf'), 'grupo2');

        $relatoriopor = new Zend_Form_Element_Select('relatoriopor');
        $relatoriopor->setLabel('Relatório por')
                ->addMultiOption('', '')
                ->addMultiOption('1', 'Aluno')
                ->addMultiOption('2', 'Curso')
                ->addMultiOption('3', 'Docente')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addValidator('NotEmpty');
        $this->addElement($relatoriopor);
        //definindo a posição do elemento no formulário
        $this->configurandoTamanho('relatoriopor', 'span4');

        $aluno = new Zend_Form_Element_Text('aluno');
        $aluno->setLabel('Aluno:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o aluno');
        $this->addElement($aluno);
        //definindo a posição do elemento no formulário
        $this->configurandoTamanho('aluno', 'span4');
        //definindo o grupo que os elementos pertencerão
        $this->montandoGrupo(array('relatoriopor', 'aluno'), 'grupo3');

        $curso = new Zend_Form_Element_Select('curso');
        $curso->setLabel('Curso:')
                ->addMultiOption('', '')
                ->addMultiOption('1', 'Administração')
                ->addMultiOption('2', 'Engenharia Ambiental')
                ->addMultiOption('3', 'Biomedicina')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addValidator('NotEmpty');
        $this->addElement($curso);
        //definindo a posição do elemento no formulário
        $this->configurandoTamanho('curso', 'span4');
        //definindo o grupo que o elemento pertencerá
        $this->montandoGrupo(array('curso'), 'grupo4');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Salvar')
                ->setAttrib('class', 'btn btn-large btn-primary')
                ->setIgnore(true);
        $this->addElement($submit);

        $limpar = new Zend_Form_Element_Reset('limpar');
        $limpar->setLabel('Filtrar')
                ->setAttrib('class', 'btn btn-large btn-warning')
                ->setIgnore(true);
        $this->addElement($limpar);

        $gravar = new Zend_Form_Element_Button('gravar');
        $gravar->setLabel('Gravar')
                ->setAttrib('class', 'btn btn-large btn-info')
                ->setIgnore(true);
        $this->addElement($gravar);
        //os botões por padrão ficarão sempre centralizados desde que façam parte do grupo botoes
        $this->montandoGrupo(array('submit', 'limpar', 'gravar'), 'botoes');
    }

}