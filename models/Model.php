<?php
namespace models;

use PDO;

class Model {

    protected function _before_write(){}
    protected function _after_write(){}
    protected function _before_delete(){}
    protected function _after_delete(){}

    static $pdo = null;
    public function __construct() {

        // 连接数据库
        if(self::$pdo === null) {
            
            self::$pdo = new \PDO('mysql:host=127.0.0.1;dbname=myself','root','');
            self::$pdo->exec("set names utf8");
        }
    }

    // 获取最新添加的记录的id
    public function lastInsertId() {

        return self::$pdo->lastInsertId();
    }
}