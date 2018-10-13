<?php
namespace models;

use PDO;

class Register extends Model {

    public function add($email,$phone,$password) {

        $stmt = self::$pdo->prepare("INSERT INTO user (email,phone,password) VALUES(?,?,?)");

        return $stmt->execute([
            $email,
            $phone,
            $password,
        ]);
    }
}