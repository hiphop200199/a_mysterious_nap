<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/db.php';

class Account_model
{
    private $db;
    public function __construct(Db $db)
    {
        $this->db = $db;
    }
    public function getList()
    {
        $sql = 'SELECT * FROM account';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function get($id)
    {
        $sql = 'SELECT * FROM account WHERE id = ? ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$id]);//所有參數都當字串看待，要自己轉型
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function edit($id,$account) {
        $sql = 'UPDATE account SET account = ?,update_time = ? WHERE id = ?';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$account,time(),$id]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM account WHERE id = ? ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function checkLogin($account,$password){
        $sql = 'SELECT * FROM account WHERE account = ? AND password = ?';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$account,$password]);
        if ($stmt->rowCount() == 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        return [];
    }
    
    public function editPassword($id,$newPassword) {
        $sql = 'UPDATE account SET password = ?,update_time = ? WHERE id = ?';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$newPassword,time(),$id]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

}
