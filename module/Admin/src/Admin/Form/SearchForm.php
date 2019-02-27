<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator\Between;

class SearchForm extends Form{

    public function __construct($searchParam,$name = null){
        parent::__construct($name,array('required'=>false,'allow_empty'=> true,'continue_if_empty' => true));
        $this->setAttribute('method','post');
        $this->setAttribute('id',$name);
        $this->add(array(
            'name'=>'s_articul',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 7,
                'label' => 'Поиск по атикулу',
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'required'=>false,
            ),
        ));

        $this->add(array(
            'name'=>'s_item',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 255,
                'label' => 'Поиск по имени (можно ввести часть)',
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'required'=>false,
            ),
        ));

        $this->add(array(
            'name'=>'s_prod',
            'type'=>'Zend\Form\Element\MultiCheckbox',
            'options'=>array(
                'value_options'=> $this->checkBoxFilter($searchParam['prod']),
                'label' => 'Выберите производителя:',
            ),
            'attributes'=>array(
                //'class'=>'form-control',
                'autocomplete'=>'off',
                'required'=>false,
            ),
        ));

        $this->add(array(
            'name'=>'s_type',
            'type'=>'Zend\Form\Element\MultiCheckbox',
            'options'=>array(
                'value_options'=> $this->checkBoxFilter($searchParam['type']),
                'label' => 'Выберите тип товара:',
            ),
            'attributes'=>array(
                //'class'=>'form-control',
                'autocomplete'=>'off',
                'required'=>false,
            ),
        ));

        $this->add(array(
            'name'=>'s_color',
            'type'=>'Zend\Form\Element\MultiCheckbox',
            'options'=>array(
                'value_options'=> $this->checkBoxFilter($searchParam['color']),
                'label' => 'Выберите цвет товара:',
            ),
            'attributes'=>array(
                //'class'=>'form-control',
                'autocomplete'=>'off',
                'required'=>false,
            ),
        ));

        $this->add(array(
            'name'=>'min_price',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 255,
                'label' => 'Минимальная цена',
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'placeholder' => $searchParam['min_price'][1],
                'required'=>false,
            ),
        ));

        $this->add(array(
            'name'=>'max_price',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 255,
                'label' => 'Максимальная цена',
                
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'placeholder' => $searchParam['max_price'][1],
                'required'=>false,
            ),
        ));
        
/*
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'from_date',
            'options' => array(
                    'format' => 'Y-m-d',
                    'label' => 'Поиск с',
            ),
            'attributes' => array(
                    'min' => $searchParam['min_date'][1],
                    'max' => $searchParam['max_date'][1],
                    'step' => '1',
                    'style' => 'border-radius: 4px; border-color: #007bff;',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'to_date',
            'options' => array(
                    'format' => 'Y-m-d',
                    'label' => 'Поиск по',
            ),
            'attributes' => array(
                    'min' => $searchParam['min_date'][1],
                    'max' => $searchParam['max_date'][1],
                    'step' => '1',
                    'style' => 'border-radius: 4px; border-color: #007bff;',
            )
        ));*/
        $this->addInputFilter();
    }

    private function addInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();
        $inputFilter->add(array(
            'name' => 'min_price',
            'allow_empty'       => true, 
            'continue_if_empty' => true,
        )
        );
        $inputFilter->add(array(
            'name' => 'max_price',
            'allow_empty'       => true, 
            'continue_if_empty' => true,
        )
        );
        $inputFilter->add(array(
            'name' => 's_item',
            'allow_empty'       => true, 
            'continue_if_empty' => true,
        )
        );
        $inputFilter->add(array(
            'name' => 's_articul',
            'allow_empty'       => true, 
            'continue_if_empty' => true,
        )
        );
        $inputFilter->add(array(
            'name' => 's_color',
            'allow_empty'       => true, 
            'continue_if_empty' => true,
        )
        );
        $inputFilter->add(array(
            'name' => 's_prod',
            'allow_empty'       => true, 
            'continue_if_empty' => true,
        )
        );
        $inputFilter->add(array(
            'name' => 's_type',
            'allow_empty'       => true, 
            'continue_if_empty' => true,
        )
        );/*
        $inputFilter->add(array(
            'name' => 'to_date',
            'allow_empty'       => true, 
            'continue_if_empty' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
            ),
        )
        );
        $inputFilter->add(array(
            'name' => 'from_date',
            'allow_empty'       => true, 
            'continue_if_empty' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
            ),
        )
        );*/

        $this->setInputFilter($inputFilter);
    }

    private function checkBoxFilter($arr){
        foreach($arr as $key => $value){
            $arr[$value] = $value;
            unset($arr[$key]);
        }
        return $arr;
    }
}