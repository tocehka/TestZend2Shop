<?php

namespace Admin\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter;

class UploadExcelForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->addElements();
        $this->addInputFilter();
    }

    private function addElements()
    {

        $file = new Element\File('excel-file');
        $file->setLabel('Загрузите Excel файл')
             ->setAttribute('id', 'excel-file');
        $this->add($file);
    }

    private function addInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();


        $fileInput = new InputFilter\FileInput('excel-file');
        $fileInput->setRequired(true);

        $fileInput->getValidatorChain()
            ->attachByName('filesize',      array('max' => 204800))
            ->attachByName('filemimetype',  array('mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'));

        $inputFilter->add($fileInput);

        $this->setInputFilter($inputFilter);
    }
}