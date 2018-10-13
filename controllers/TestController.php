<?php
namespace controllers;

class TestController{

    public function testMail1() {

        $mail = new \libs\Mail;
        $mail->send('测试meil类','测试meil类',['czxy_fym@163.com','玥饼']);
    }

    // 发邮件
    public function testMail() {

        // 设置邮件服务器账号
        $transport = (new \Swift_SmtpTransport('smtp.126.com', 25))  // 邮件器服务IP地址和端口号
        ->setUsername('czxy_qz@126.com')       // 发邮件账号
        ->setPassword('12345678abcdefg');      // 授权码

        // 创建发邮件对象
        $mailer = new \Swift_Mailer($transport);

        // 创建邮件消息
        $message = new \Swift_Message();

        $message->setSubject('测试标题')   // 标题
                ->setFrom(['czxy_qz@126.com' => '全栈1班'])   // 发件人
                ->setTo(['czxy_fym@163.com', 'czxy_fym@163.com' => '玥饼'])   // 收件人
                ->setBody('Hello <a href="http://localhost:9999">点击激活</a> World ~', 'text/html');     // 邮件内容及邮件内容类型

        // 发送邮件
        $ret = $mailer->send($message);
        var_dump($ret);
    }

}