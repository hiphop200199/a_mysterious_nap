<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/db.php';
class Initial_situation_model
{
    private $db;
    public function __construct(Db $db)
    {
        $this->db = $db;
    }
    public function getList()
    {
        $sql = 'SELECT * FROM  initial_situation';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get($id)
    {
        $sql = 'SELECT * FROM initial_situation WHERE id = ? ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function create($name, $voiceOver, $imageSourceString,$awakeDegree)
    {
        $sql = 'INSERT INTO initial_situation VALUES( ?,?,?,?,?,?,? ) ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([null, $name, $voiceOver, $imageSourceString,$awakeDegree, time(), time()]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function edit($id, $name, $voiceOver, $imageSourceString,$awakeDegree)
    {
        $sql = 'UPDATE initial_situation SET name = ?,voice_over = ?,image = ?,awake_degree = ?,update_time = ? WHERE id = ?';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$name,$voiceOver, $imageSourceString,$awakeDegree, time(), $id]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM initial_situation WHERE id = ? ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function getMaxId()
    {
        $sql = 'SELECT id FROM initial_situation ORDER BY id DESC LIMIT 1 ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return 0;
        }
        return intval($result['id']);
    }

    

    //web


    public function getListFrontend($keyword = null, $category, $editor)
    {
        $sql = 'SELECT * FROM joke WHERE status = 2 ';
        $params = [];

      /*   if (!empty($keyword)) {
            $sql .= " AND question LIKE ? OR answer LIKE ? ";
            $params = ["'%$keyword%'", "'%$keyword%'"];
        } */

        if (!empty($category)) {
            $arr = array_map('intval', explode(',', $category));
            $str = '';
            for ($i = 0; $i < count($arr); $i++) {
                $i == count($arr) - 1 ? $str .= '?' : $str .= '?,';
                $params[] = $arr[$i];
            }
            $sql .= " AND category IN ($str) ";
        }

        if (!empty($editor)) {
            $arr = array_map('intval', explode(',', $editor));
            $str = '';
            for ($i = 0; $i < count($arr); $i++) {
                $i == count($arr) - 1 ? $str .= '?' : $str .= '?,';
                $params[] = $arr[$i];
            }
            $sql .= " AND editor IN ($str) ";
        }



        $sql .= " ORDER BY createtime DESC ";
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute($params);

        if (/* empty($keyword) && */ empty($category) && empty($editor)) {
            $result = [];
            return $result;
        } else if ($stmt->rowCount() >= 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            $result = SERVER_INTERNAL_ERROR;
            return $result;
        }
    }


    public function getFrontend($id)
    {
        $mainSql = 'SELECT j.*,jc.name AS category_name,a.name AS editor_name  FROM joke AS j 
        JOIN joke_category AS jc ON j.category = jc.id
        JOIN admin_account AS a ON j.editor = a.id
        WHERE j.status = 2 AND j.id = ?
        ';
       
        $rateSql = 'SELECT * FROM joke_rate WHERE joke_id = ?';

        $mainStmt =  $this->db->conn->prepare($mainSql);
        $rateStmt = $this->db->conn->prepare($rateSql);
        $mainStmt->execute([$id]);
        if ($mainStmt->rowCount() == 1) {
            $mainInfo = $mainStmt->fetch(PDO::FETCH_ASSOC);
            $mainStmt->closeCursor();
            $rateStmt->execute([$id]);     
            if ($rateStmt->rowCount() < 0) {
                $result = SERVER_INTERNAL_ERROR;
                return $result;
            }
            $mainInfo['rateinfo'] = $rateStmt->fetchAll(PDO::FETCH_ASSOC);
            $rateStmt->closeCursor();
            return $mainInfo;       
        } 
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function getRandomJoke()
    {
        $sql = 'SELECT j.question,j.answer,j.image,a.name FROM joke AS j
           JOIN admin_account AS a ON j.editor = a.id
           WHERE j.status = 2
           ORDER BY RAND() LIMIT 1
           ';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function getJokeEvaluation()
    {
        $sql = 'SELECT ta.* FROM (SELECT j.question,j.answer,j.image,jr.joke_id,AVG(jr.score) AS avg_score,a.name FROM joke AS j
           JOIN joke_rate AS jr ON j.id = jr.joke_id
           JOIN admin_account AS a ON j.editor = a.id
          GROUP BY jr.joke_id
          ORDER BY avg_score DESC LIMIT 1) AS ta
          UNION
          SELECT tb.* from (SELECT j.question,j.answer,j.image,jr.joke_id,AVG(jr.score) AS avg_score,a.name FROM joke AS j
           JOIN joke_rate AS jr ON j.id = jr.joke_id
           JOIN admin_account AS a ON j.editor = a.id
          GROUP BY jr.joke_id
          ORDER BY avg_score  LIMIT 1) as tb';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 2) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function createRate($id, $comment, $score)
    {
        $sql = 'INSERT INTO joke_rate VALUES(?,?,?,?,?)';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute([null, $id, $score, $comment, time()]);
        if ($stmt->rowCount() == 1) {
            $result = SUCCESS;
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

    public function getRandomQuestion()
    {
        $sql = 'SELECT * FROM joke ORDER BY RAND() LIMIT 4';
        $stmt =  $this->db->conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 4) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        $result = SERVER_INTERNAL_ERROR;
        return $result;
    }

}
