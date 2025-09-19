<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/util.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/admin/common.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constant.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Index extends Common
{

    

    private function login()
    {
        session_start();
        $account = htmlspecialchars(strip_tags($_POST['account']));
        $password = hash('sha256', $_POST['password']);
        $captcha = htmlspecialchars(strip_tags($_POST['captcha']));
        if ($_SESSION['code'] != $captcha) {
            session_regenerate_id();
            $result = ['errCode' => CAPTCHA_ERROR];
            echo json_encode($result);
            exit;
        }
        $account_info = $this->account_model->checkLogin($account, $password);
        if (empty($account_info)) {
            session_regenerate_id();
            $result = ['errCode' => ACCOUNT_OR_PASSWORD_ERROR];
            echo json_encode($result);
            exit;
        }
        if ($account_info['status'] !== ACTIVE) {
            session_regenerate_id();
            $result = ['errCode' => ACCOUNT_INACTIVE];
            echo json_encode($result);
            exit;
        }
        session_regenerate_id();
        setcookie('auth', $account_info['id'] . '|' . hash('sha256', $account_info['id'] . $account_info['account'] . $account_info['password']  . (string)time())  . '|' . (string)time(), time() + 86400, '/', 'a-mysterious-nap.infinityfreeapp.com', true, true);
        $result = ['errCode' => SUCCESS, 'redirect' => 'account/list.php'];
        echo json_encode($result);
        exit;
    }

    private function logout()
    {
        setcookie('auth', '', time() - 86400, '/', 'a-mysterious-nap.infinityfreeapp.com', true, true);
        $response = json_encode(['errCode'=>SUCCESS,'redirect'=>ROOT.'/page/admin/login.php']);
        echo $response;
        exit;
    }
}

$index = new Index(new Account_model(new Db()));

Util::requestEntry(object: $index);

unset($index);
