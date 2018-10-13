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
        // $redis = \libs\Redis::getInstance();
        @$data = $_SESSION['data'];
        // 把数组转为字符串
        $value = explode('',[
            $_SESSION['email'] => $email,
            $_SESSION['phone'] => $phone,
            $_SESSION['password'] => $password,
        ]);
        // 键名
        $key = "temp_user:{$code}";
        // $_SESSION['data']->setex($key, 300, $value);

        // 把激活码发送到用户的邮箱中
        

        // 3.发邮件
        $mail = new \libs\Mail;
        $content = "点击以下链接进行激活：<br>激活码是：{$code}";
        // 从邮箱地址中取出姓名
        $name = explode('@',$email);

        // 构造收件人地址 [czxy_fym@163.com , czxy_fym]
        $from = [$email, $name[0]];
        // 发邮件
        $mail->send('注册成功',$content,$from);
        
        echo 'OK';
       
    }


    // 激活账号
    public function activeUser() {

        // 1.接收激活码
        $code = $_GET['code'];

        @$data = $_SESSION['data'];

        // 拼出名字
        $key = 'temp_user:'.$code;
        $sj = $data->get($key);
        // 判断有没有
        if($sj) {

            $data->del($key);
            $sj = implode($sj, true);
            // 插入到数据库
            $user = new Register;
            $user->add($user->add($sj['data'],$sj['phone'],$sj['password']));
            die("激活成功，您可以登录了");
        } else {

            die('激活码无效');
        }
    }

    // 发邮件
    public function mail() {

        // 设置 socket 永不超时
        ini_set('default_socket_timeout',-1);

        echo '邮件程序已启动';

        // 连接redis
        $redis = new \Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);

        // 循环监听一个列表
        while(true) {

            // 从队列中取出数据，设置为永久不超时
            $data = $redis->brpop('email',0);
            echo '开始发邮件';
            // 处理数据
            var_dump($data);
            echo '发完邮件，继续等待';
        }
    }

    // 显示表单
    public function register() {

        view('login.register');   
    }

    
}