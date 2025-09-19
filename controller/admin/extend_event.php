<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/common.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/joke_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/util.php';



class Extend_event extends Common
{
    private $extend_event_model;
    public function __construct(Extend_event_model $extend_event_model,Account_model $account_model)
    {
        parent::__construct($account_model);
        parent::init();
        $this->extend_event_model = $extend_event_model;
    }

   

    public function index()
    {
        $list = $this->extend_event_model->getList();
        return $list;
    }

    public function get($id)
    {
        $info = $this->extend_event_model->get($id);
        return $info;
    }

    private function create()
    {
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $voiceOver = htmlspecialchars(strip_tags($_POST['voice_over']));
        $initialSituationId = intval($_POST['initial_situation_id']);
        $image = $_FILES['image'];
        $allowFileTypes = ['image/png','image/jpg','image/jpeg','image/gif'];
        $imageSourceString = '';
     
        if(!empty($image)){
            if(!in_array($image['type'],$allowFileTypes)){
                $response = json_encode(['errCode'=>FILE_FORMAT_ERROR]);
                echo $response;
                exit;
            }
            $maxId = $this->checkMaxId();
            $targetDirectory = $_SERVER['DOCUMENT_ROOT'].'/upload/extend_event/';
            $targetFileName = ($maxId+1).'-'. basename($image['name']);
            $targetFile = $targetDirectory .$targetFileName;
            if(move_uploaded_file($image['tmp_name'],$targetFile)){
              $imageSourceString = '/upload/extend_event/'.$targetFileName;
            }
        }

        $result = $this->extend_event_model->create($initialSituationId,$name,$voiceOver,$imageSourceString);
        if ($result === SUCCESS) {
            $response = json_encode(['errCode' => SUCCESS, 'redirect' => 'list.php']);
            echo $response;
            exit;
        }
        $response = json_encode(['errCode' => SERVER_INTERNAL_ERROR]);
        echo $response;
        exit;
    }

    private function edit()
    {
        $id = intval($_POST['id']);
        $checkExist = $this->extend_event_model->get($id);
        if (empty($checkExist)) {
            $response = json_encode(['errCode' => CURSE_CATEGORY_NOT_EXIST]);
            echo $response;
            exit;
        }
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $voiceOver = htmlspecialchars(strip_tags($_POST['voice_over']));
        $image = empty($_FILES['image'])?'':$_FILES['image'];
        $allowFileTypes = ['image/png','image/jpg','image/jpeg','image/gif'];
        $oldImage = empty($checkExist['image'])?'':$checkExist['image'];
        $imageSourceString = empty($image)?$oldImage:'';
        
        if(!empty($image)&&!empty($oldImage)&&file_exists($_SERVER['DOCUMENT_ROOT'].$oldImage)){
            unlink($_SERVER['DOCUMENT_ROOT'].$oldImage);
        }

        if(!empty($image)){
            if(!in_array($image['type'],$allowFileTypes)){
                $response = json_encode(['errCode'=>FILE_FORMAT_ERROR]);
                echo $response;
                exit;
            }
            
            $targetDirectory = $_SERVER['DOCUMENT_ROOT'].'/upload/extend_event/';
            $targetFileName = $id.'-'. basename($image['name']);
            $targetFile = $targetDirectory .$targetFileName;
            if(move_uploaded_file($image['tmp_name'],$targetFile)){
              $imageSourceString = '/upload/extend_event/'.$targetFileName;
            }
        }
       
        $result = $this->extend_event_model->edit($id,$name,$voiceOver,$imageSourceString);
        if ($result === SUCCESS) {
            $response = json_encode(['errCode' => SUCCESS, 'redirect' => 'list.php']);
            echo $response;
            exit;
        } 
        $response = json_encode(['errCode' => SERVER_INTERNAL_ERROR]);
        echo $response;
        exit;
    }

    private function delete()
    {
        $id = intval($_POST['id']);
        $checkExist = $this->extend_event_model->get($id);
        if (empty($checkExist)) {
            $response = json_encode(['errCode' => CURSE_CATEGORY_NOT_EXIST]);
            echo $response;
            exit;
        }
        if(!empty($checkExist['image'])&&file_exists($_SERVER['DOCUMENT_ROOT'].$checkExist['image'])){
            unlink($_SERVER['DOCUMENT_ROOT'].$checkExist['image']);
        }
    
        $result = $this->extend_event_model->delete($id);
        if($result===SUCCESS){
            $response = json_encode(['errCode' => SUCCESS, 'redirect' => 'list.php']);
            echo $response;
            exit;
        }     
        $response = json_encode(['errCode' => SERVER_INTERNAL_ERROR]);
        echo $response;
        exit;
    }

    private function checkMaxId(){
        $id = $this->extend_event_model->getMaxId();
        return $id;
    }
}



$db = new Db();

$joke = new Extend_event(new Extend_event_model($db),new Account_model($db));

Util::requestEntry(object: $joke);

unset($joke);
