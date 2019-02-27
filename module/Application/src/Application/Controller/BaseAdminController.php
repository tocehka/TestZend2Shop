<?php

namespace Application\Controller;

use PHPExcel_IOFactory;
use Shop\Entity\Items;

class BaseAdminController extends BaseController{

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        return parent::onDispatch($e);
    }

    protected function processExcel($tmpName){
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($tmpName);
        $checkVoid = false;
        $em = $this->getEntityManager();
        $excelData = array();
        for($i = 2; $checkVoid == false; $i++){
            $tmpMassive = array();
            for($ascii = 65; $ascii<73; $ascii++){
                if($objPHPExcel->getActiveSheet()->getCell(chr($ascii).$i)->getValue()=='' && $ascii != 72){
                    $checkVoid = true;
                    break;
                }elseif($ascii>=65 && $ascii<70){
                    if(!is_string($objPHPExcel->getActiveSheet()->getCell(chr($ascii).$i)->getValue())){
                        $cell = chr($ascii).$i;
                        return array('error'=>"Неверный формат данных в Excel в ячейке $cell");
                    }else{
                        $tmpMassive[$objPHPExcel->getActiveSheet()->getCell(chr($ascii).'1')->getValue()] = $objPHPExcel->getActiveSheet()->getCell(chr($ascii).$i)->getValue();
                    }
                }elseif($ascii>=70 && $ascii<72){
                    if(!is_int($objPHPExcel->getActiveSheet()->getCell(chr($ascii).$i)->getValue()) && !is_float($objPHPExcel->getActiveSheet()->getCell(chr($ascii).$i)->getValue())){
                        $cell = chr($ascii).$i;
                        $kell = $objPHPExcel->getActiveSheet()->getCell(chr($ascii).$i)->getValue();
                        return array('error'=>"Данные должны быть представлены в числовом формате в ячейке $cell");
                    }else{
                        $tmpMassive[$objPHPExcel->getActiveSheet()->getCell(chr($ascii).'1')->getValue()] = $objPHPExcel->getActiveSheet()->getCell(chr($ascii).$i)->getValue();
                    }
                }
            }
            $items = new Items();
                try{
                    $items->exchangeArray($tmpMassive);
                    $em->persist($items);
                    $em->flush();
                }catch(\Exeption $e){
                    return array('error'=>'Ошибка добавления в базу данных: '.$e);
                }
        }
        return array('success'=>'Все позиции из Excel успешно добавлены');
    }

    protected function getLimitDBValues(){
        $em = $this->getEntityManager();
        $valuesMas['prod'] = array();
        foreach($em->createQuery("SELECT t.prod FROM Shop\Entity\Items t")->getResult() as $value){
            array_push($valuesMas['prod'],$value['prod']);
        }
        $valuesMas['prod'] = array_unique($valuesMas['prod']);

        $valuesMas['type'] = array();
        foreach($em->createQuery("SELECT t.type FROM Shop\Entity\Items t")->getResult() as $value){
            array_push($valuesMas['type'],$value['type']);
        }
        $valuesMas['type'] = array_unique($valuesMas['type']);

        $valuesMas['color'] = array();
        foreach($em->createQuery("SELECT t.color FROM Shop\Entity\Items t")->getResult() as $value){
            array_push($valuesMas['color'],$value['color']);
        }
        $valuesMas['color'] = array_unique($valuesMas['color']);

        foreach($em->createQuery("SELECT MIN(t.price) FROM Shop\Entity\Items t")->getResult() as $value){
            $valuesMas['min_price'] = $value;
        }
        foreach($em->createQuery("SELECT MAX(t.price) FROM Shop\Entity\Items t")->getResult() as $value){
            $valuesMas['max_price'] = $value;
        }
        foreach($em->createQuery("SELECT MAX(t.date) FROM Shop\Entity\Items t")->getResult() as $value){
            $valuesMas['max_date'] = $value;
        }
        foreach($em->createQuery("SELECT MIN(t.date) FROM Shop\Entity\Items t")->getResult() as $value){
            $valuesMas['min_date'] = $value;
        }
        //print_r($valuesMas);
        return $valuesMas;
    }

}