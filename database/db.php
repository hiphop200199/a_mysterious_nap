<?php

 
 require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php'; 
 class Db{
  public $conn;
  public function __construct(){
    try {
      $this->conn = new PDO('mysql:host='.DB_SERVER_NAME.';dbname='.DB_DATABASE_NAME, DB_USER_NAME, DB_PASSWORD);
      // set the PDO error mode to exception
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
 }
 