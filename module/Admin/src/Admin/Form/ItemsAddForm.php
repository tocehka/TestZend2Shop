<?php

namespace Admin\Form;

use Zend\Form\Form;

class ItemsAddForm extends Form{

    public function __construct($name = null){
        parent::__construct('itemsAddForm');
        $this->setAttribute('method','post');
        $this->setAttribute('class','bs-example form-horizontal');

        $this->add(array(
            'name'=>'articul',
            'type'=>'text',
            'options'=>array(
                'label' => 'Артикул товара',
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'required'=>'required',
            ),
        ));

        $this->add(array(
            'name'=>'item',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 255,
                'label' => 'Наименование товара',
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'required'=>'required',
            ),
        ));

        $this->add(array(
            'name'=>'prod',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 255,
                'label' => 'Производитель товара',
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'required'=>'required',
            ),
        ));

        $this->add(array(
            'name'=>'type',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 255,
                'label' => 'Тип товара',
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'required'=>'required',
            ),
        ));

        $this->add(array(
            'name'=>'color',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 50,
                'label' => 'Цвет товара',
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'required'=>'required',
            ),
        ));

        $this->add(array(
            'name'=>'price',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 6,
                'label' => 'Цена товара',
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'required'=>'required',
            ),
        ));

        $this->add(array(
            'name'=>'sale',
            'type'=>'text',
            'options'=>array(
                'min' => 1,
                'max' => 6,
                'label' => 'Скидка на товар в % товара',
            ),
            'attributes'=>array(
                'class'=>'form-control',
            ),
        ));

        $this->add(array(
            'name'=>'submit',
            'type'=>'submit',
            'attributes'=>array(
                'value'=>'Сохранить',
                'id'=>'btn-submit',
                'class'=>'btn btn-primary',
            ),
        ));
    }

}