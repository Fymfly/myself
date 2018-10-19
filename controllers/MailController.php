<?php
namespace controllers;

use libs\Mail;

class MailController extends BaseController{

    public function send() {

        // 连接redis
        $redis = \libs\Redis::getInstance();

        $mailer = new Mail;

        // 设置 socket 永不超时
        ini_set('default_socket_timeout',-1);

        echo '发邮件队列启动成功..';
        
        // 循环从队列中取消息并发邮件
        while(true) {

            // 1、先从队列中取消息
            // 从 从email 里取消消息
            $data = $redis->brpop('email',0);

            // 2、发邮件
            // 取出消息并反序列化
            $message = json_decode($data[1], TRUE);

            // 发邮件
            $mailer->send($message['title'],$message['content'],$message['from']);
            
            echo '发送邮件成功，等待下一个';
        }

    }
}