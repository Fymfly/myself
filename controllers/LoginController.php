<?php
namespace controllers;

use models\Login;

class LoginController {

    public function test() {

        $moedel = new login;
        $moedel->getUalPath(2);
    }

    public function login() {

        view('login.index');
    }

    public function dologin() {

        $username = $_POST['username'];
        $password = md5($_POST['password']);
        
        
        $user = new Login;
        
        // var_dump($username,$password);
        if($user->login($username,$password)) {
            // echo 'sdf';
            redirect('/');
            // view('index.index');
        } else {

            die('用户名或者密码错误');
        }
    }

    
    public function logout() {

        $_SESSION = [];
        redirect('/login/login');
    }
}