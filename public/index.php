<?php
// 定义常量
define('ROOT',dirname(__FILE__).'/../');     // 项目根目录
require(ROOT.'vendor/autoload.php');

date_default_timezone_set('PRC');

//设置SESSION 保存
ini_set('session.save_handler','redis');
ini_set('session.save_path','tcp://127.0.0.1:6379?database=3');
//开启session
session_start();

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
if(php_sapi_name()=='cli'){
    
    //得到控制器和方法名
    $controller = ucfirst($argv[1]).'Controller';
    $action = $argv[2];
   
  }else{
    if( isset($_SERVER['PATH_INFO']) )
    {
        $pathInfo = $_SERVER['PATH_INFO'];
        // 根据 / 转成数组
        $pathInfo = explode('/', $pathInfo);

        // 得到控制器名和方法名 ：
        $controller = ucfirst($pathInfo[1]) . 'Controller';
        $action = $pathInfo[2];
    }else{
    //默认控制器和方法
    $controller = 'IndexController';
    $action = 'Index';
  }
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


function redirect($url) {

    header('Location:'.$url);
    exit;
}


//获取当前URL上的参数 并且还能排除掉某些参数
function getUrlParams($except = [])
{
    // ['odby','odway']
    // 循环删除变量
    foreach($except as $v)
    {
        unset($_GET[$v]);
    }


    $str = '';
    foreach($_GET as $k => $v)
    {
        $str .= "$k=$v&";
    }

    return $str;

}

// 读取配置文件(特点：无论调用多次，只包含一次配置文件)
// 静态局部变量：函数执行结束，也不会销毁，一直存在整个脚本
// 普通局部变量：函数执行完就销毁
function config($name) {
    
    static $config = null;
    if($config === null) {

        // 引入配置文件
        $config = require(ROOT.'config.php');
    }

    return $config[$name];
}
