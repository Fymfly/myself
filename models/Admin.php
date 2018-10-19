<?php
namespace models;

use PDO;

class Admin extends Model {

    public function index() {

        $stmt = self::$pdo->prepare("SELECT a.*,a.username,c.role_name
                                        FROM admin a 
                                        LEFT JOIN admin_role b on a.id=b.admin_id
                                        LEFT JOIN role c ON b.role_id=c.id
                                        GROUP BY a.id");
        $stmt->execute();
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );

        return $data;
    }


    // 获取一个管理员有权访问的权限的路径
    public function getUalPath($adminId) {

        $stmt = self::$pdo->prepare("SELECT c.url_path
                                        FROM admin_role a
                                        LEFT JOIN role_privlege b ON a.role_id=b.role_id
                                        LEFT JOIN privilege c ON b.pri_id=c.id
                                        WHERE a.admin_id=? AND c.url_path != ''"); 
        $stmt->execute([$adminId]);
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC);

        // 把二维数组转为一维数组
        $_ret = [];

        foreach($data as $v) {

            // 判断是否有多个URL（包含）
            if(FALSE === strpos($v['url_path'], ',')) {

                // 如果没有 ‘ ，’ 就直接拿过来
                $_ret[] = $v['url_path'];
            
            } else {

                // 如果有就转成数组
                $_tt = explode(',', $v['url_path']);
                // 把转完之后的数组合并到一堆数组中
                $_ret = array_merge($_ret, $_tt);
            }

        }

        var_dump($_ret);
        return $_ret;
    }
}