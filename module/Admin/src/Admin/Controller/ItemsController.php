<?php

namespace Admin\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;
use Application\Controller\BaseAdminController as BaseAdmin;
use Admin\Form\ItemsAddForm;
use Shop\Entity\Items;
use Admin\Form\UploadExcelForm;
use Admin\Form\SearchForm;

class ItemsController extends BaseAdmin
{
    public function indexAction()
    {   
        $sortType = ($this->params()->fromQuery('type','DESC') == 'DESC') ? 'ASC' : 'DESC';
        //$query = $this->querySortManager($this->params()->fromQuery('orderby','date'), $this->params()->fromQuery('type','DESC'));
        //$rows = $query->getResult();
        $getParams = '';
        $getSortParams = '';
        foreach($this->params()->fromQuery() as $field => $query){
            if($field!='page'&&$field!='type'&&$field!='orderby'){
                $getParamsMas[$field] = '';/*
                if($field=='s_prod'||$field=='s_type'||$field=='s_color'){
                    $getParams .= $field.'=';
                    foreach($query as $uno){
                        $getParams .= $uno.',';
                        $getParamsMas[$field] .= $uno.',';
                    }
                    $getParamsMas[$field] = trim($getParamsMas[$field],',');
                    $getParams = trim($getParams,',');
                }else{*/
                    $getParams .= $field.'='.$query.'&';
                    $getParamsMas[$field] = $query;
                
            }elseif($field=='type'||$field=='orderby'){
                $getSortParams .= $field.'='.$query.'&';
            }
        }
        $getParams = trim($getParams,'&');
        $getSortParams = trim($getSortParams,'&');
        if(isset($getParamsMas)){
            $this->querySearchManager($getParamsMas);
        }
        $paginate =$this->paginateSmth($this->querySortManager($this->params()->fromQuery('orderby','date'), $this->params()->fromQuery('type','DESC')));
        $valuesMas = $this->getLimitDBValues();
        $form_upload = new UploadExcelForm('upload-form');
        $form_search = new SearchForm($valuesMas,'search-form');
        $status = '';
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $checkSearchForm = $this->checkPostSearchForm($request->getPost());
            if(!$checkSearchForm){
                $post = array_merge_recursive(
                    $request->getPost()->toArray(),
                    $request->getFiles()->toArray()
                );
                $form_upload->setData($post);
                if ($form_upload->isValid()) {
                    $data = $form_upload->getData();
                    move_uploaded_file($data['excel-file']['tmp_name'],'kek.xlsx');
                    $processMessage = $this->processExcel('kek.xlsx');
                    $status = (isset($processMessage['success'])) ? 'success' : 'error';
                    $message = (isset($processMessage['success'])) ? $processMessage['success'] : $processMessage['error'];
                    $this->flashMessenger()->setNamespace($status)->addMessage($message);
                    unlink('kek.xlsx');
                    return $this->redirect()->toRoute('admin/items');
                }else{
                    $data = $form_upload->getData();
                    $status = 'error';
                    $message = 'Файл должен быть в формате xlsx';
                    $this->flashMessenger()->setNamespace($status)->addMessage($message);
                    return $this->redirect()->toRoute('admin/items');
                }
            }elseif($checkSearchForm){
                $form_search->setData($request->getPost());
                if($form_search->isValid()){
                    $data_form = $form_search->getData();
                    /*$item = $this->getEntityManager()->createQuery("SELECT t FROM Shop\Entity\Items t WHERE t.articul='".$data_form['s_articul']."'")->getResult();
                    foreach($item as $it){
                        $kek=$it->getProd();
                    }
                    if(empty($item)){
                        $status = 'error';
                        $message = 'Товара с таким артикулом не существует';
                        $this->flashMessenger()->setNamespace($status)->addMessage($message);
                        return $this->redirect()->toRoute('admin/items');
                    }
                    $_SESSION['pag'] = $this->paginateSmth($item);*/
                    $searchQuery = '';
                    foreach($data_form as $field => $value){
                        if($value!=''){
                            if(is_array($value)){
                                $searchQuery .= $field.'=';
                                foreach($value as $param){
                                    $searchQuery .= $param.',';
                                }
                                $searchQuery = trim($searchQuery,',');
                            }else{
                                $searchQuery .= $field.'='.$value.'&';
                            }
                        }
                    }
                    $searchQuery = trim($searchQuery,'&');
                    return $this->redirect()->toUrl(stristr($this->getRequest()->getUri()->toString(),'?',TRUE).'?'.$searchQuery);
                }else{/*
                    foreach ($form_search->getMessages() as $messageId => $message) {
                        echo "Validation failure '$messageId': $message\n";
                    }*/
                    $status = 'error';
                    $message = $form_search->getMessages();
                    $this->flashMessenger()->setNamespace($status)->addMessage($message);
                    return $this->redirect()->toRoute('admin/items');
                }
            }
        }
        return array('get_sort_params'=>$getSortParams,'get_params'=>$getParams,'items' => $paginate, 'sorttype' => $sortType, 'page'=>'page='.$this->params()->fromQuery('page',1), 'form' => $form_upload, 'form_search' => $form_search);
    }

    public function addAction(){

        $form = new ItemsAddForm();
        $status = '';
        $message = '';
        $em = $this->getEntityManager();
        $request = $this->getRequest();

        if ($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $data_form = $form->getData();
                $item = $em->getRepository('Shop\Entity\Items')->findOneBy(array('articul' => $data_form['articul']));
                if(!empty($item)){
                    $status = 'error';
                    $message = 'Товар с таким артикулом уже существует';
                    $this->flashMessenger()->setNamespace($status)->addMessage($message);
                    return $this->redirect()->toRoute('admin/items');
                }
                $items = new Items();
                $items->exchangeArray($data_form);
                $em->persist($items);
                $em->flush();
                $status = 'success';
                $message = 'Товар успешно добавлен';
            }else{
                $status = 'error';
                $message = 'Ошибка в вводимых параметрах';
            }
        }else{
            return array('form' => $form);
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/items');
    }

    public function editAction(){

        $form = new ItemsAddForm();
        $status = '';
        $message = '';
        $em = $this->getEntityManager();
        $id = (int) $this->params()->fromRoute('id',0);
        $item = $em->find('Shop\Entity\Items',$id);
        if(empty($item)){
            $status = 'error';
            $message = 'Товар не найден';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/items');
        }
        $form->bind($item);
        $request = $this->getRequest();

        if ($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $em->persist($item);
                $em->flush();

                $status = 'success';
                $message = 'Товар изменен';
            }else{
                $status = 'error';
                $message = 'Ошибка в вводимых параметрах';
            }
        }else{
            return array('form' => $form, 'id' => $id);
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/items');
    }

    public function deleteAction(){
        $status = '';
        $message = '';
        $em = $this->getEntityManager();
        $id = (int) $this->params()->fromRoute('id',0);
        try {
            $item = $em->find('Shop\Entity\Items',$id);
            if(empty($item)){
                $status = 'error';
                $message = 'Нельзя удалить товар, которого не существует';
                $this->flashMessenger()->setNamespace($status)->addMessage($message);
                return $this->redirect()->toRoute('admin/items');
            }
            $em->remove($item);
            $em->flush();
            $kek = $item->getArticul();
            $status = 'success';
            $message = "Товар с артикулом $kek удален";
        }catch(\Exeption $e){
            $status = 'error';
            $message = 'Ошибка удаления';
        }
        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/items');
    }
}
