<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/common.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/extend_event_result_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/util.php';



class Extend_event_result extends Common
{
    private $extend_event_result_model;
    public function __construct(Extend_event_result_model $extend_event_result_model, Account_model $account_model)
    {
        parent::__construct($account_model);
        parent::init();
        $this->extend_event_result_model = $extend_event_result_model;
    }

   

    public function index()
    {
        $list = $this->extend_event_result_model->getList();
        return $list;
    }

    public function get($id)
    {
        $info = $this->extend_event_result_model->get($id);
        return $info;
    }

    private function create()
    {
        $extendEventOptionId = intval($_POST['extend_event_option_id']);
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $voiceOver = htmlspecialchars(strip_tags($_POST['voice_over']));
      
        $result = $this->extend_event_result_model->create($extendEventOptionId,$name,$voiceOver);
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
        $checkExist = $this->extend_event_result_model->get($id);
        if (empty($checkExist)) {
            $response = json_encode(['errCode' => CURSE_CATEGORY_NOT_EXIST]);
            echo $response;
        }
        $result = $this->extend_event_result_model->edit($id, $name, $voiceOver);
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
        $result = $this->extend_event_result_model->delete($id);
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

$extend_event_result = new Extend_event_result(new Extend_event_result_model($db), new Account_model($db));

Util::requestEntry(object: $extend_event_result);

unset($extend_event_result);
