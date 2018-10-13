<?php
namespace models;

class Blog extends Model{

    public function add($title,$content,$user_id) {

        $stmt = self::$pdo->prepare("INSERT INTO blogs(title,content,user_id) VALUES(?,?,?)");
        $ret = $stmt->execute([
            $title,
            $content,
            $user_id
        ]);
        if(!$ret) {

            echo '失败';
            // 获取失败信息
            $error = $stmt->errorInfo();
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
        // 取出数据
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );

        return $data;

        // var_dump($data);
    }
}