<?php
namespace controllers;

class BaseController {

    public function __construct() {

        // 判断登录
        if(!isset($_SESSION['id'])) {

            redirect('/login/login');
        }

        // 是否是超级管理员，直接改函数
        if(isset($_SESSION['root'])) {
             return ;
        }
        // var_dump($_SERVER['PATH_INFO']);die;
        // 获取将要访问的路径
        $path = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/'):'index/index';
        // var_dump($path);
        
        // 设置一个白名单
        $whiteList = ['index/index'];

        // 判断是否有权访问
        if(!in_array($path, array_merge($whiteList, $_SESSION['url_path']))) {

            die('无权访问!');
        } 
    }
}