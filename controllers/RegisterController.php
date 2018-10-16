<?php
namespace controllers;

use PDO;
use \models\Register;

class RegisterController{

    public function store() {

        // 1、接收表单
        $email = $_POST['email'];
        // $mobile = $_POST['mobile'];
        $password = md5($_POST['password']);

        // 生成激活码(随机的字符串)
        $code = md5( rand(1,99999) );
        var_dump($code);

        // 把消息放到队列中
        $redis = \libs\Redis::getInstance();
        // var_dump($redis);

        // 序列化(数组转成 json 字符串)
        $value = json_encode([
            'email' => $email,
            'password' => $password,
        ]);
        // var_dump($value);

        // 键名
        $key = "temp_user:{$code}";
        $redis->setex($key, 300, $value);

        
        // 把激活码发送到用户的邮箱中
        // 从邮箱地址中取出姓名
        $name = explode('@',$email);
        // var_dump($name);
        // 构造收件人地址 [czxy_fym@163.com , czxy_fym]
        $from = [$email, $name[0]];
        // var_dump($from);

        // 3. 把消息放到队列中
        $message = [
            'title' => '账号激活',
            'content'=> "点击以下链接进行激活：<br> 点击激活：
            <a href='http://localhost:9999/register/activeUser?code={$code}'>
            http://localhost:9999/register/activeUser?code={$code}</a><p>
            如果按钮不能点击，请复制上面链接地址，在浏览器中访问来激活账号！</p>",  
            'from' => $from,
        ];

        var_dump($message);
        // die;

        // 把消息转成字符串(JSON ==> 序列化)
        $message = json_encode($message);
        // var_dump('<pre>');
        // var_dump($message);

        // 3、放到队列中
        // 连接redis
        $redis = \libs\Redis::getInstance();
        
        $redis->lpush('email',$message);
        
        echo 'OK';

    }


    // 激活账号
    public function activeUser() {

        // 1.接收激活码
        $code = $_GET['code'];
        // var_dump($code);

        // 到 redis 取出账号
        $redis = \libs\Redis::getInstance();

        // var_dump($redis);

        // 拼出名字
        $key = 'temp_user:'.$code;
        // var_dump($key);
        $data = $redis->get($key);
        // var_dump($data);
        // 判断有没有
        if($data) {

            // 从redis删除
            $redis->del($key);
            
            // 反序列化
            $data = json_decode($data, true);
            var_dump($data);
            // 插入到数据库
            $user = new Register;
            var_dump('dags');
            $user->add($data['email'], $data['password']);
            // die("激活成功，您可以登录了");
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
        $redis = \libs\Redis::getInstance();

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


    // 发送短信验证
    public function sendmobilecode() {

        // 生成6位随机数
        $code = rand(10000,90000);


         // 发短信
         $config = [
            'accessKeyId'    => 'LTAIfGI6uvRzJ1gJ',
            'accessKeySecret' => '8sJjVNXak3PqlloVr2LoReaqKpGMm4',
          ];  
          $client  = new Client($config);
          $sendSms = new SendSms;
          $sendSms->setPhoneNumbers($req->mobile);
          $sendSms->setSignName('全栈1SNS项目');
          $sendSms->setTemplateCode('SMS_128890229');
          $sendSms->setTemplateParam(['code' => $code ]);

          // 发送
          $client->execute($sendSms);
    }

    // 显示表单
    public function register() {

        view('login.register');   
    }

    
}