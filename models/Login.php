<?php
namespace models;

use PDO;

class Login extends Model{

    public function login($username,$password) {

        
        $stmt = self::$pdo->prepare('SELECT * FROM admin WHERE username=? AND password=?');
        $stmt->execute([
            $username,
            $password 
        ]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        // var_dump($user);die; 
        // var_dump($user);
        if($user) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // 查看该管理员是否有一个角色ID=1
            $stmt = self::$pdo->prepare("SELECT COUNT(*) FROM admin_role WHERE role_id=1 AND admin_id=?");
            $stmt->execute([$_SESSION['id']]);
            $c = $stmt->fetch(\PDO::FETCH_COLUMN);
            if($c>0) 
                $_SESSION['root'] = true; 
            else 
                // 取出这个管理员有权访问的路径
                $_SESSION['url_path'] = $this->getUalPath($_SESSION['id']);
            // var_dump($_SESSION['url_path']);die; 
            // var_dump('sefs');
            return true;
            // var_dump($data);
        } else {

            return FALSE;
        }
    }

    // 获取一个管理员有权访问的路径
    public function getUalPath($adminId) {

        $stmt = self::$pdo->prepare("SELECT c.url_path
                                        FROM admin_role a
                                        LEFT JOIN role_privlege b ON a.role_id=b.role_id
                                        LEFT JOIN privilege c ON b.pri_id=c.id
                                        WHERE a.admin_id=? AND c.url_path != ''"); 
        $stmt->execute([$adminId]);
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC);
        // var_dump($data);

        // 把二维数组转为一维数组
        $_ret = [];
        // var_dump($data);

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

        // var_dump($_ret);
        return $_ret;
    }
}