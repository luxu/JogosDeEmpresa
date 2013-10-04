<?php

class Aluno_Form_Aluno extends Aluno_Form_Formdecorator {

   public function init() {


      $this->setAction('/aluno/index/add')
              ->setMethod('post');

      $ter_codigo = new Zend_Form_Element_Select('ter_codigo',
                      array('label' => '* Termo:',
                          'class' => 'select3 borda-arredondada')
      );
      $termos = new Termo_Model_Termo();
      $resultPos = $termos->fetchAll()->toArray();
      $optionsPos = array();
      foreach ($resultPos as $value) {
         $optionsPos[$value['ter_codigo']] = $value['ter_descricao'];
      }
      $ter_codigo->setMultiOptions($optionsPos);
      $ter_codigo->setRequired(true);
      $this->addElement($ter_codigo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('ter_codigo', 'span3');
      //definindo o grupo que o elemento pertencerá

      $cur_codigo = new Zend_Form_Element_Select('cur_codigo',
                      array('label' => '* Curso:',
                          'class' => 'select3 borda-arredondada')
      );
      $cursos = new Curso_Model_Curso();
      $resultPos = $cursos->fetchAll()->toArray();
      $optionsPos = array();
      foreach ($resultPos as $value) {
         $optionsPos[$value['cur_codigo']] = $value['cur_descricao'];
      }
      $cur_codigo->setMultiOptions($optionsPos);
      $cur_codigo->setRequired(true);
      $this->addElement($cur_codigo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('cur_codigo', 'span3');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array('ter_codigo',
          'cur_codigo'
              ),
              'grupo1');

      $alu_nome = new Zend_Form_Element_Text('alu_nome');
      $alu_nome->setLabel('Nome: *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o nome');
      $this->addElement($alu_nome);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('alu_nome', 'span3');
      //definindo o grupo que o elemento pertencerá

      $alu_ra = new Zend_Form_Element_Text('alu_ra');
      $alu_ra->setLabel('R.A.: *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o RA');
      $this->addElement($alu_ra);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('alu_ra', 'span3');
      //definindo o grupo que o elemento pertencerá

      $alu_tipo = new Zend_Form_Element_Text('alu_tipo');
      $alu_tipo->setLabel('Tipo: * (1-Adm / 2-Não adm.)')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe o tipo');
      $this->addElement($alu_tipo);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('alu_tipo', 'span4');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array('alu_nome',
          'alu_ra',
          'alu_tipo'
              ),
              'grupo2');

      $alu_senha = new Zend_Form_Element_Password('alu_senha');
      $alu_senha->setLabel('Senha: *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('title', 'Informe a senha');
      $this->addElement($alu_senha);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('alu_senha', 'span3');

      $alu_acesso = new Zend_Form_Element_Radio('alu_acesso');
      $alu_acesso->setLabel("Acesso? *")
              ->setValue("S");
      $alu_acesso->addMultiOption("S", "Sim");
      $alu_acesso->addMultiOption("N", "Não");
      $this->addElement($alu_acesso);
      //definindo a posição do elemento no formulário
      $this->configurandoTamanho('alu_acesso', 'span3');
      //definindo o grupo que o elemento pertencerá
      $this->montandoGrupo(array('alu_senha',
          'alu_acesso'
              ), 'grupo3');

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
