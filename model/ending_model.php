<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/db.php';
class Ending_model
{
    private $db;
    public function __construct(Db $db)
    {
        $this->db = $db;
    }
    public function getList()
    {
        $sql = 'SELECT * FROM  ending';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get($id)
    {
        $sql = 'SELECT * FROM ending WHERE id = ? ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function create($name, $voiceOver)
    {
        $sql = 'INSERT INTO ending VALUES( ?,?,?,?,? ) ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([null, $name, $voiceOver, time(), time()]);
        if ($stmt->rowCount() == 1) {
            $id = intval($this->db->conn->lastInsertId());
            $result = ['errCode' => SUCCESS, 'id' => $id];
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function edit($id, $name,  $voiceOver)
    {
        $sql = 'UPDATE ending SET name = ?,voice_over = ?,update_time = ? WHERE id = ?';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$name,  $voiceOver,  time(), $id]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ending WHERE id = ? ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }


    //web


    public function getListFrontend()
    {
        $sql = 'SELECT * FROM curse WHERE status = 2 ';
        $sql .= " ORDER BY createtime DESC ";
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() >= 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }


    public function getFrontend($id)
    {
        $mainSql = 'SELECT c.*,a.name AS editor_name  FROM curse AS c
        JOIN admin_account AS a ON c.editor = a.id
        WHERE c.id = ? AND c.status = 2
        ';
        $strategySql = 'SELECT * FROM curse_strategy WHERE curse_id = ?';

        $mainStmt =  $this->db->conn->prepare($mainSql);
        $strategyStmt = $this->db->conn->prepare($strategySql);
        $mainStmt->execute([$id]);
        if ($mainStmt->rowCount() == 1) {
            $mainInfo = $mainStmt->fetch(PDO::FETCH_ASSOC);
            $mainStmt->closeCursor();
            $strategyStmt->execute([$id]);
            if ($strategyStmt->rowCount() < 0) {
                $result = SERVER_INTERNAL_ERROR;
                return $result;
            }
            $mainInfo['strategyInfo'] = $strategyStmt->fetchAll(PDO::FETCH_ASSOC);
            $strategyStmt->closeCursor();
            return $mainInfo;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }


    public function createStrategy($id, $content)
    {
        $sql = 'INSERT INTO curse_strategy VALUES(?,?,?,?)';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([null, $id, $content, time()]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }
}
