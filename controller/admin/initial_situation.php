<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/common.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/initial_situation_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/util.php';



class Initial_situation extends Common
{
    private $initial_situation_model;
    public function __construct(Initial_situation_model $initial_situation_model,Account_model $account_model)
    {
        parent::__construct($account_model);
        parent::init();
        $this->initial_situation_model = $initial_situation_model;
    }

   

    public function index()
    {
        $list = $this->initial_situation_model->getList();
        return $list;
    }

    public function get($id)
    {
        $info = $this->initial_situation_model->get($id);
        return $info;
    }

    private function create()
    {
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $voiceOver = htmlspecialchars(strip_tags($_POST['voice_over']));
        $awakeDegree = intval($_POST['awake_degree']);
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
            $targetDirectory = $_SERVER['DOCUMENT_ROOT'].'/upload/initial_situation/';
            $targetFileName = ($maxId+1).'-'. basename($image['name']);
            $targetFile = $targetDirectory .$targetFileName;
            if(move_uploaded_file($image['tmp_name'],$targetFile)){
              $imageSourceString = '/upload/initial_situation/'.$targetFileName;
            }
        }

        $result = $this->initial_situation_model->create($name,$voiceOver,$imageSourceString,$awakeDegree);
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
        $checkExist = $this->initial_situation_model->get($id);
        if (empty($checkExist)) {
            $response = json_encode(['errCode' => CURSE_CATEGORY_NOT_EXIST]);
            echo $response;
            exit;
        }
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $voiceOver = htmlspecialchars(strip_tags($_POST['voice_over']));
        $awakeDegree = intval($_POST['awake_degree']);
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
            
            $targetDirectory = $_SERVER['DOCUMENT_ROOT'].'/upload/initial_situation/';
            $targetFileName = $id.'-'. basename($image['name']);
            $targetFile = $targetDirectory .$targetFileName;
            if(move_uploaded_file($image['tmp_name'],$targetFile)){
              $imageSourceString = '/upload/initial_situation/'.$targetFileName;
            }
        }
       
        $result = $this->initial_situation_model->edit($id,$name,$voiceOver,$imageSourceString,$awakeDegree);
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
        $checkExist = $this->initial_situation_model->get($id);
        if (empty($checkExist)) {
            $response = json_encode(['errCode' => CURSE_CATEGORY_NOT_EXIST]);
            echo $response;
            exit;
        }
        if(!empty($checkExist['image'])&&file_exists($_SERVER['DOCUMENT_ROOT'].$checkExist['image'])){
            unlink($_SERVER['DOCUMENT_ROOT'].$checkExist['image']);
        }
    
        $result = $this->initial_situation_model->delete($id);
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
        $id = $this->initial_situation_model->getMaxId();
        return $id;
    }
}



$db = new Db();

$joke = new initial_situation(new initial_situation_model($db),new Account_model($db));

Util::requestEntry(object: $joke);

unset($joke);
