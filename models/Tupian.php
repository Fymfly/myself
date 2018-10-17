<?php
namespace models;

class Tupian extends Model{

    // 多图片上传
   public function images($image) {

        // 上传图片（保存数据库）
   
        $stmt = self::$pdo->prepare("INSERT INTO blogs_image(user_id,uploads) VALUES(?,?)");
        $stmt->execute([
            $_SESSION['id'],
            $image,
        ]);
    }

    // 图片主页显示图片
    public function index() {

        $stmt = self::$pdo->prepare("SELECT a.*,b.username 
                                        FROM blogs_image a
                                        LEFT JOIN user b ON a.user_id = b.id");
        $stmt->execute();
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );
        return $data;
    }


   // 图片上传
   public function image() {

        // $image = $_POST['image'];

        // var_dump('<pre>');
        // var_dump($_FILES);

        // 创建目录
        $root = 'public/uploads/';
        
        // 今天日期
        $date = date('Ymd');

        // 如果没有这个目录就创建目录
        if(!is_dir($root . $date)) {

            // 创建目录
            mkdir($root.$date , 0777,true);
        }

        // 生成唯一的名字
        $name = md5( time() . rand(1,9999) );   // 32 位字符串

        // 先取出原来这个图片的后缀
        // strrchr：从最后某一个字符开始截取到最后
        $ext = strrchr($_FILES['image']['name'],'.');

        $name = $name . $ext;

        // 移动图片
        move_uploaded_file($_FILES['image']['tmp_name'] , $root . $date . '/' . $name);

        // $image =  $root . $date . '/' . $name;

      
        // echo $image;
        // die;
   }


  
}