<?php
namespace models;

class Login extends Model{

    public function login($username,$password) {

        
        $stmt = self::$pdo->prepare('SELECT * FROM user WHERE username=? AND password=?');
        $stmt->execute([
            $username,
            $password
        ]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        // var_dump($user);
        if($user) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return TRUE;
        } else {

            return FALSE;
        }
    }
}