<?php
namespace models;

class Blog extends Model{

    public function add($title,$content,$image) {
        // $user_id =  $_SESSION['id'];

        // var_dump('<pre>');
        // var_dump($_FILES);
        // die;
        // 上传图片
        // 先创建目录
        
        // var_dump($image);
        // die;

        // $file = $_FILES['image'];
        // $name = time().'.jpg';
        // $image = move_uploaded_file($file['tmp_name'], ROOT.'public/uploads/'.$name);

        // 把图片保存到数据库
        // $data = [
        //     $title,
        //     $content,
        //     $user_id,
        //     $image,
        // ];
        // echo "<pre>";
        // var_dump($data);die;
        $stmt = self::$pdo->prepare("INSERT INTO blogs(title,content,user_id,image) VALUES(?,?,?,?)");
        $ret = $stmt->execute([
            $title,
            $content,
            $_SESSION['id'],
            $image,
        ]);
        // var_dump($stmt);
        // die;
        if(!$ret) {

            echo '失败';
            // 获取失败信息
            $error = $stmt->errorInfo();
            var_dump($error);
        }


        // 返回新插入的记录的ID
        // return self::$pdo->lastIndertId();
    }

    public function delete($id) {

        $stmt = self::$pdo->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->execute([
            $id,
        ]);
    }

    public function Dodata() {

        // 预处理
        $stmt = self::$pdo->query("SELECT * FROM blogs");
        // $stmt = $this->_db->prepare("SELECT * FROM blogs");
        // 取出数据
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );

        return $data;

        // var_dump($data);
    }
}