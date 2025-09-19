<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/common.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/ending_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/util.php';



class Ending extends Common
{
    private $ending_model;
    public function __construct(Ending_model $ending_model, Account_model $account_model)
    {
        parent::__construct($account_model);
        parent::init();
        $this->ending_model = $ending_model;
    }

   

    public function index()
    {
        $list = $this->ending_model->getList();
        return $list;
    }

    public function get($id)
    {
        $info = $this->ending_model->get($id);
        return $info;
    }

    private function create()
    {
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $voiceOver = htmlspecialchars(strip_tags($_POST['voice_over']));
      
        $result = $this->ending_model->create($name,$voiceOver);
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
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $voiceOver = htmlspecialchars(strip_tags($_POST['voice_over']));
        $checkExist = $this->ending_model->get($id);
        if (empty($checkExist)) {
            $response = json_encode(['errCode' => CURSE_CATEGORY_NOT_EXIST]);
            echo $response;
        }
        $result = $this->ending_model->edit($id, $name, $voiceOver);
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
        $result = $this->ending_model->delete($id);
        if ($result === SUCCESS) {
            $response = json_encode(['errCode' => SUCCESS, 'redirect' => 'list.php']);
            echo $response;
            exit;
        }
        $response = json_encode(['errCode' => SERVER_INTERNAL_ERROR]);
        echo $response;
        exit;
    }

}

$db = new Db();

$ending = new ending(new Ending_model($db), new Account_model($db));

Util::requestEntry(object: $ending);

unset($ending);
