<?php
namespace models;

class Blog extends Model{

    // 添加日志
    public function add($title,$content,$image,$classify_id) {
    
        $stmt = self::$pdo->prepare("INSERT INTO blogs(title,content,user_id,image,classify_id) VALUES(?,?,?,?,?)");
        $ret = $stmt->execute([
            $title,
            $content,
            $_SESSION['id'],
            $image,
            $classify_id,
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

    // 查询分类
    public function classifySQl() {

        $stmt = self::$pdo->prepare("SELECT * FROM blogs_classify");
        $stmt->execute([]);
        return $stmt->fetchAll( \PDO::FETCH_ASSOC);
    }


    // 删除日志
    public function delete($id) {

        $stmt = self::$pdo->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->execute([
            $id,
        ]);
    }

    // 日志列表
    public function Dodata() {

        // 预处理
        // $stmt = self::$pdo->query("SELECT * FROM blogs");
        $stmt = self::$pdo->query("SELECT b.*,bc.classify,u.username
                    FROM blogs b
                    LEFT JOIN blogs_classify bc on b.classify_id = bc.id
                    LEFT JOIN user u on b.user_id = u.id");
        //select a.id,title,content,created_at,link, cat_name from article a left join article_category b on a.article_category_id = b.id

        // $stmt = $this->_db->prepare("SELECT * FROM blogs");
        // 取出数据
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );

        return $data;

        // var_dump($data);
    }


    // 修改日志
    public function findOne($blogId) {

        $stmt = self::$pdo->prepare("SELECT * FROM blogs WHERE id = ?");
        $stmt->execute([
            $blogId,
        ]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // 修改模型（更新数据)
    public function update($blogId,$title,$content) {

        $stmt = self::$pdo->prepare("UPDATE blogs SET title=?,content=? where id=?");
        $stmt->execute([
            $title,
            $content,
            $blogId,
        ]);
        // var_dump($stmt);
    }
}