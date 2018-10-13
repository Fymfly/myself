<?php
// 定义常量
define('ROOT',dirname(__FILE__).'/../');     // 项目根目录
require(ROOT.'vendor/autoload.php');

// 自动加载
function autoload($class){
    // echo $class;
    $path = str_replace('\\','/',$class);
    // echo '<br>'; echo $path;
    require ROOT.$path.'.php';
    // var_dump(ROOT.$path.'.php');
 
}
spl_autoload_register('autoload');

// 添加路由: 解析 URL 上的路径：控制器/方法
// 获取URL上的路径
if(isset($_SERVER['PATH_INFO'])) {
    
    $pathInfo = $_SERVER['PATH_INFO'];
    // var_dump($pathInfo);

    // 转成数组
    $pathInfo = explode('/' , $pathInfo);

    // 得到控制器名 和 方法名
    $controller = ucfirst($pathInfo[1]).'Controller';
    $action = $pathInfo[2];
} else {

    // 默认控制器 和 方法
    $controller = 'IndexController';
    $action = 'Index';
}
    
// 为控制器添加命名空间
$fullController = 'controllers\\'.$controller;


// 加载视图
// 参数一：加载的视图的文件名
// 参数二：向视图中传的数据
function view($file, $data=[]) {
    // extract 可以把一个数组转为多个变量
    extract( $data );

    // 加载视图文件
    $path = str_replace('.' , '/' , $file). '.html';
    require(ROOT.'views/'.$path);
}                          

$_C = new $fullController;
$_C->$action();


function redirect($url)
    {
        header('Location:'.$url);
        exit;
    }
