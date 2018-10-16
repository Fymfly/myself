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


    // 搜索日志
    public function search(){
    
        
        $where = 1;

        // 放预处理对应的值
        $value = [];
        //如果传了 keyword 参数并且值不为空添加where 条件
        if(isset($_GET['keywords']) && $_GET['keywords']){

            $where .= " AND (title like ? OR content like ?)";
            $value[] ='%'.$_GET['keywords'].'%';
            $value[] ='%'.$_GET['keywords'].'%';
            
        }
        //日期字段搜索
        if(isset($_GET['start_date']) && $_GET['start_date'])
         {
             $where .= " AND (created_at LIKE ? OR created_at LIKE ?)";
             $value[] = '%'.$_GET['start_date'].'%';
             $value[] = '%'.$_GET['start_date'].'%';
         }
        
        //分页
        $perpage = 5; // 每页15
        // 接收当前页码（大于等于1的整数）， max：最参数中大的值
        $page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
        // 计算开始的下标
        // 页码  下标
        // 1 --> 0
        // 2 --> 15
        // 3 --> 30
        // 4 --> 45
        $offset = ($page-1)*$perpage;

        // 制作按钮
        // 取出总的记录数
        $stmt = self::$pdo->prepare("SELECT COUNT(*) FROM blogs WHERE $where");
        $stmt->execute($value);
        $count = $stmt->fetch( \PDO::FETCH_COLUMN );
        // 计算总的页数（ceil：向上取整（天花板）， floor：向下取整（地板））
        $pageCount = ceil( $count / $perpage );

        $btns = '';
        for($i=1; $i<=$pageCount; $i++)
        {
            // 先获取之前的参数
            $params = getUrlParams(['page']);

            $class = $page==$i ? 'active' : '';
            $btns .= "<a class='$class' href='?{$params}page=$i'> $i </a>";
            
        }

    
        /*================= 执行sql ============*/ 
        // 预处理 SQL
        $stmt = self::$pdo->prepare("SELECT b.*,bc.classify,u.username
        FROM blogs b
        LEFT JOIN blogs_classify bc on b.classify_id = bc.id
        LEFT JOIN user u on b.user_id = u.id WHERE $where LIMIT $offset,$perpage");  
        
        // 执行 SQL
        $stmt->execute($value);

        // 取数据
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       
        

        //加载视图
       return[
           'btns'=>$btns,
           'data'=>$data,
       ];
    } 

}