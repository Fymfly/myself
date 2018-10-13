<?php
namespace models;

use PDO;

class Model {

    static $pdo = null;
    public function __construct() {

        // 连接数据库
        if(self::$pdo === null) {
            
            self::$pdo = new \PDO('mysql:host=127.0.0.1;dbname=myself','root','');
            self::$pdo->exec("set names utf8");
        }
    }
}