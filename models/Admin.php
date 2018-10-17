<?php
namespace models;

class Admin extends Model {

    public function index() {

        $stmt = self::$pdo->prepare("SELECT a.*,a.username,c.role_name
                                        FROM admin a 
                                        LEFT JOIN admin_role b on a.id=b.admin_id
                                        LEFT JOIN role c ON b.role_id=c.id
                                        GROUP BY a.id");
        //select a.id,title,content,created_at,link, cat_name from article a left join article_category b on a.article_category_id = b.id
        // SELECT a.id,a.role_name,GROUP_CONCAT(c.pri_name) pri_list
        //                                 FROM role a
        //                                 LEFT JOIN role_privlege b ON a.id=b.role_id
        //                                 LEFT JOIN privilege c ON b.pri_id=c.id
        //                                 GROUP BY a.id
        $stmt->execute();
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );

        return $data;
    }
}