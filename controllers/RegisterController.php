<?php
namespace controllers;

use PDO;
use \models\Register;

class RegisterController{

    // 注册
    public function store() {

        // 1.接收表单
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = md5($_POST['password']);

        // var_dump($phone,$password);

        // // 2.插入到数据库中
        // $user = new Register;
        // $ret = $user->add($email,$phone,$password);
        // // echo 'sdfg';
        // if(!$ret) {
        //     die('注册失败');
        // }

        // 生成激活码(随机的字符串)
        $code = md5( rand(1,99999) );

        // 保存到 redis
        $redis = new \libs\Redis;
        // 把数组转为字符串
        $value = implode('',[
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
        ]);
        // 键名
        $key = "temp_user:{$code}";
        $redis->setex($key, 300, $value);

        // 把激活码发送到用户的邮箱中
        

        // 3.发邮件
        $mail = new \libs\Mail;
        $content = '恭喜您，注册成功!';
        // 从邮箱地址中取出姓名
        $name = explode('@',$email);

        // 构造收件人地址 [czxy_fym@163.com , czxy_fym]
        $from = [$email, $name[0]];
        // 发邮件
        $mail->send('注册成功',$content,$from);
        
        echo 'OK';
       
    }

    // 显示表单
    public function register() {

        view('login.register');   
    }

    
}