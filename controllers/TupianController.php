<?php
namespace controllers;

use Intervention\Image\ImageManagerStatic as Image;

class TupianController extends BaseController{

    // 显示图片视图
    public function index() {
        $model = new \models\Tupian;
        $data = $model->index();

        view('tupian.index',$data);
    }

    // 显示上传图片视图
    public function create() {

        view('tupian.create');
    }

    // 上传多张图片
    public function uploadall(){

          $image = $_FILES['image'];

        
          // 创建目录
          $root = '/public/uploads/';
          //    var_dump($root);
           
          // 今天日期
          $date = date('Ymd');
   
          // 如果没有这个目录就创建目录
          if(!is_dir($root . $date)) {
   
              // 创建目录
              mkdir($root.$date , 0777,true);
          }
         
   
          $doimage = new \models\Tupian;
          // 循环五张图片的 name
          foreach($_FILES['image']['name'] as $k => $v) {
              // 生成唯一的名字
              $name = md5( time() . rand(1,9999) );   // 32 位字符串
               // var_dump($name);
              // 先取出原来这个图片的后缀
              // strrchr：从最后某一个字符开始截取到最后
              $ext = strrchr($v,'.');
   
              $name = $name . $ext;
   
              // 移动图片          根据name的下标，找到对应的临时文件
              move_uploaded_file($_FILES['image']['tmp_name'][$k] , $root . $date . '/' . $name);
   
               $image = $root . $date . '/' . $name;
               
               $doimage->images($image);
            
            
          }
         
          redirect('/tupian/index');
          
    }

    // 上传图片
    public function setimg() {

        $image = $_FILES['image'];
        echo '<pre>';
        // var_dump(is_dir(ROOT . 'public/uploads/album'));
        // var_dump(ROOT . 'public/uploads/album/');
        // die;
        // 打开这个图片     并生成缩略图
        $img = Image::make($image['tmp_name']);
        // 缩放图片
        $img->resize(50,50);
        $img->save(ROOT . 'public/uploads/album/1.png');
        $img->resize(100,100);
        $img->save(ROOT . 'public/uploads/album/2.png');
        $img->resize(200,200);
        $img->save(ROOT . 'public/uploads/album/3.png');
    }
}