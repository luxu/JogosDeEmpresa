<?php

class Usuario_Form_Usuario extends Zend_Dojo_Form {

    protected $_selectOptions = array(
        'red'    => 'Rouge',
        'blue'   => 'Bleu',
        'white'  => 'Blanc',
        'orange' => 'Orange',
        'black'  => 'Noir',
        'green'  => 'Vert',
    );

    public function init() {
        $this->setAction('/usuario/index/add');



//        $element->addDecorator('DijitElement')
//                ->addDecorator('Errors')
//                ->addDecorator('HtmlTag', array('tag' => 'dd'))
//                ->addDecorator('Label', array('tag' => 'dt'));

//        $form->addElement(
//                'ComboBox',
//                'foo',
//                array(
//                    'label' => 'ComboBox (select)',
//                    'value' => 'blue',
//                    'autocomplete' => false,
//                    'multiOptions' => array(
//                        'red' => 'Rouge',
//                        'blue' => 'Bleu',
//                        'white' => 'Blanc',
//                        'orange' => 'Orange',
//                        'black' => 'Noir',
//                        'green' => 'Vert',
//                    ),
//                )
//        );
//
//        $form->addElement(
//                'ComboBox',
//                'foo',
//                array(
//                    'label' => 'ComboBox (select)',
//                    'value' => 'blue',
//                    'autocomplete' => false,
//                    'multiOptions' => array(
//                        'red' => 'Rouge',
//                        'blue' => 'Bleu',
//                        'white' => 'Blanc',
//                        'orange' => 'Orange',
//                        'black' => 'Noir',
//                        'green' => 'Vert',
//                    ),
//                )
//        );
        $coordenador = new Zend_Dojo_Form_Element_ComboBox('coordenador');
        $coordenador->setLabel('Coordenador:');
        $coordenador->setOptions(array(
                    'autocomplete' => true,
                    'storeID' => 'alu_codigo',
                    'storeType' => 'dojo.data.ItemFileReadStore',
                    'storeParams' => array('url' => "/usuario/index/autocomplete"),
                    'dijitParams' => array('searchAttr' => 'alu_codigo')))
                ->setRequired(true)
                ->addValidator('NotEmpty', true)
                ->addFilter('HTMLEntities')
                ->addFilter('StringToLower')
                ->addFilter('StringTrim');

        $aluno = new Zend_Dojo_Form_Element_ValidationTextBox('alu_codigo');
        $aluno->setLabel('Aluno:');

        $selectForm = new Zend_Dojo_Form_SubForm();
        $selectForm->setAttribs(array(
            'name'   => 'selecttab',
            'legend' => 'Select Elements',
        ));
        $selectForm->addElement(
                'FilteringSelect',
                'filterselect',
                array(
                    'label' => 'FilteringSelect (select)',
                    'value' => 'blue',
                    'autocomplete' => false,
                    'multiOptions' => $this->_selectOptions,
                )
            );
//            ->addElement(
//                'FilteringSelect',
//                'filterselectremote',
//                array(
//                    'label' => 'FilteringSelect (remoter)',
//                    'storeId' => 'stateStore',
//                    'storeType' => 'dojo.data.ItemFileReadStore',
//                    'storeParams' => array(
//                        'url' => '/js/states.txt',
//                    ),
//                    'dijitParams' => array(
//                        'searchAttr' => 'name',
//                    ),
//                )
//            );

        $submit = new Zend_Dojo_Form_Element_SubmitButton('submit');
        $submit->setLabel('Salvar');

        $limpar = new Zend_Dojo_Form_Element_Button('limpar');
        $limpar->setLabel('Limpar');

        $this->addSubForm($selectForm, 'selecttab');
        $this->addElements(array(
            $coordenador,
            $aluno,
//            $selectForm,
            $submit,
            $limpar
        ));
    }
}
