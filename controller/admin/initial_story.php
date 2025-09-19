<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/common.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/initial_story_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/util.php';



class Initial_story extends Common
{
    private $initial_story_model;
    public function __construct(Initial_story_model $initial_story_model, Account_model $account_model)
    {
        parent::__construct($account_model);
        parent::init();
        $this->initial_story_model = $initial_story_model;
    }

   

    public function index()
    {
        $list = $this->initial_story_model->getList();
        return $list;
    }

    public function get($id)
    {
        $info = $this->initial_story_model->get($id);
        return $info;
    }

    private function create()
    {
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $voiceOver = htmlspecialchars(strip_tags($_POST['voice_over']));
      
        $result = $this->initial_story_model->create($name,$voiceOver);
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
        $checkExist = $this->initial_story_model->get($id);
        if (empty($checkExist)) {
            $response = json_encode(['errCode' => CURSE_CATEGORY_NOT_EXIST]);
            echo $response;
        }
        $result = $this->initial_story_model->edit($id, $name, $voiceOver);
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
        $result = $this->initial_story_model->delete($id);
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

$initial_story = new initial_story(new Initial_story_model($db), new Account_model($db));

Util::requestEntry(object: $initial_story);

unset($initial_story);
