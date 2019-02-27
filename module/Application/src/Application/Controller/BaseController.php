<?php


namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class BaseController extends AbstractActionController
{

    protected $entityManager;
    protected $query;

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        return parent::onDispatch($e);
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager(){
        return $this->entityManager;
    }

    protected function paginateSmth($query){
        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        $paginate = new Paginator($adapter);
        $paginate->setDefaultItemCountPerPage(10);
        return $paginate->setCurrentPageNumber((int)$this->params()->fromQuery('page',1));
    }
    protected function checkPostSearchForm($arrPost){
        $checkPostArr = array('s_articul','s_item','s_prod','s_type','s_color','min_price','max_price','from_date','to_date');
        foreach($checkPostArr as $atr){
            if($arrPost->$atr!==null){
                return true;
            }
        }
        return false;
    }

    protected function querySortManager($orderBy = 'date', $type = 'DESC'){
        if ($this->query==null){
            return $this->getEntityManager()->createQuery("SELECT t FROM Shop\Entity\Items t ORDER BY t.$orderBy $type");
        }else{
            //var_dump($this->getEntityManager()->createQuery("SELECT t FROM Shop\Entity\Items t WHERE $this->query ORDER BY t.$orderBy $type")->getResult());
            return $this->getEntityManager()->createQuery("SELECT t FROM Shop\Entity\Items t WHERE $this->query ORDER BY t.$orderBy $type");
        }
    }

    protected function querySearchManager($params){
        $query = '';
        foreach($params as $param => $get){
            if($param=='s_articul'){
                $query .= 't.'.substr($param,2)."='".$get."'";
            }elseif($param=='s_item'){
                $query .= 't.'.substr($param,2)." LIKE '%".$get."%'";
            }elseif($param=='from_date'){
                $query .= 't.'.substr($param,5).">='".$get."'";
            }elseif($param=='to_date'){
                $query .= 't.'.substr($param,3)."<='".$get."'";
            }elseif($param=='min_price'){
                $query .= 't.'.substr($param,4).">=".$get."";
            }elseif($param=='max_price'){
                $query .= 't.'.substr($param,4)."<=".$get."";
            }elseif($param=='s_color'){
                $get = explode(',',$get);
                $query .=' (';
                foreach($get as $value){
                    $query .= 't.'.substr($param,2)."='".$value."' OR ";
                }
                $query = substr($query,0,strlen($query)-4);
                $query .=') ';
            }elseif($param=='s_prod'){
                $get = explode(',',$get);
                $query .=' (';
                foreach($get as $value){
                    $query .= 't.'.substr($param,2)."='".$value."' OR ";
                }
                $query = substr($query,0,strlen($query)-4);
                $query .=') ';
            }elseif($param=='s_type'){
                $get = explode(',',$get);
                $query .=' (';
                foreach($get as $value){
                    $query .= 't.'.substr($param,2)."='".$value."' OR ";
                }
                $query = substr($query,0,strlen($query)-4);
                $query .=') ';
            }
            $query .= ' AND ';
        }
        $query = substr($query,0,strlen($query)-5);
        print_r($query);
        //print_r($this->getEntityManager()->createQuery("SELECT t FROM Shop\Entity\Items t WHERE $query")->getResult());
        return $this->query=$query;
    }
}
