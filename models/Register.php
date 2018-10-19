<?php
namespace models;

use PDO;

class Register extends Model {

    public function add($email,$password) {

        $stmt = self::$pdo->prepare("INSERT INTO admin (email,password) VALUES(?,?)");

        return $stmt->execute([
            $email,
            // $mobile,
            $password,
        ]);
    }

    public function getActiveUsers() {

        $redis = \libs\Redis::getInstance();
        $data = $redis->get('activeUser');

        // 反序列化(转为数组 true：数组， false：对象)
        return json_decode($data, true);
    }
}