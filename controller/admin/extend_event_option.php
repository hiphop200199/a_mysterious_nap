<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/common.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/extend_event_option_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/util.php';



class Extend_event_option extends Common
{
    private $extend_event_option_model;
    public function __construct(Extend_event_option_model $extend_event_option_model, Account_model $account_model)
    {
        parent::__construct($account_model);
        parent::init();
        $this->extend_event_option_model = $extend_event_option_model;
    }

   

    public function index()
    {
        $list = $this->extend_event_option_model->getList();
        return $list;
    }

    public function get($id)
    {
        $info = $this->extend_event_option_model->get($id);
        return $info;
    }

    private function create()
    {
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $voiceOver = htmlspecialchars(strip_tags($_POST['voice_over']));
        $extendEventId = intval($_POST['extend_event_id']);
        $isEnd = intval($_POST['is_end']);
        $awakeDegreeAdjust = intval($_POST['awake_degree_adjust']);

        $result = $this->extend_event_option_model->create($extendEventId,$name,$voiceOver,$isEnd,$awakeDegreeAdjust);
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
        $isEnd = intval($_POST['is_end']);
        $awakeDegreeAdjust = intval($_POST['awake_degree_adjust']);
        $checkExist = $this->extend_event_option_model->get($id);
        if (empty($checkExist)) {
            $response = json_encode(['errCode' => CURSE_CATEGORY_NOT_EXIST]);
            echo $response;
        }
        $result = $this->extend_event_option_model->edit($id, $name, $voiceOver,$isEnd,$awakeDegreeAdjust);
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
        $result = $this->extend_event_option_model->delete($id);
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

$extend_event_option = new extend_event_option(new extend_event_option_model($db), new Account_model($db));

Util::requestEntry(object: $extend_event_option);

unset($extend_event_option);
