<?php
namespace models;

class Role extends Model{
    public $data;

    public function index() {
        $stmt = self::$pdo->prepare("SELECT a.id,a.role_name,GROUP_CONCAT(c.pri_name) pri_list
                                        FROM role a
                                        LEFT JOIN role_privlege b ON a.id=b.role_id
                                        LEFT JOIN privilege c ON b.pri_id=c.id
                                        GROUP BY a.id");
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        // echo "<pre>";
        // var_dump($data);die;
        return $data;
    }

    // 添加
    public function add($role_name) {

        $stmt = self::$pdo->prepare("INSERT INTO role(role_name) VALUES(?)");
        $stmt->execute([
            $role_name,
        ]);

        $this->data['id'] = $this->lastInsertId();

        // var_dump($role_name);
        $this->_after_write();      
    }
    

    // 添加、修改角色之后自动加载被执行
    // 添加时，获取新添加的角色ID : $this->data['id']
    // 修改时，获取要修改的角色ID : $_GET['id]
    public function _after_write() {

        $roleId = isset($_GET['id']) ? $_GET['id'] : $this->data['id'];

        // 删除原权限
        // echo '<pre>';
        // var_dump($_POST);
        // exit;
        $stmt = self::$pdo->prepare("DELETE FROM role_privlege WHERE role_id =?");
        $stmt->execute([
            $roleId
        ]);
        
        // 重新修改勾选的数据
        $stmt = self::$pdo->prepare("INSERT INTO role_privlege(pri_id,role_id) VALUES(?,?)");
        foreach($_POST['pri_id'] as $v) {

            $stmt->execute([
                $v,
                // $this->data['id'],
                $roleId
            ]);
        }
        

        // var_dump($role_name);
    }


    // 显示修改页数据
    public function edit(){

        $stmt = self::$pdo->prepare("SELECT * FROM role WHERE id=?");
        $stmt->execute([$_GET['id']]);
        $data = $stmt->fetch( \PDO::FETCH_ASSOC );

        return $data;
    }
    // 取出角色id所拥有的权限id
    public function getPriIds($roleId) {
        // 预处理
        $stmt = self::$pdo->prepare("SELECT pri_id FROM role_privlege WHERE role_id=?");
        
        // 执行
        $stmt->execute([
            $roleId
        ]);
        
        // 取数据
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // 转成一维数组
        $_ret = [];
        foreach($data as $k => $v) {

            $_ret[] = $v['pri_id'];
        }
        
        // 把一维的返回
        return $_ret;
    }
    // 处理修改表单
    public function update($role_name,$roleId){
        // var_dump($roleId);die;
        $stmt = self::$pdo->prepare("UPDATE role SET role_name=? where id=?");
        $data = $stmt->execute([
            $role_name, 
            $roleId
        ]);
        // $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $this->_after_write();
        // return $data; 
        
    }

    // 删除
    public function delete() {

        $stmt = self::$pdo->prepare("DELETE FROM role WHERE id = ?");
        $data = $stmt->execute([
            $_GET['id'],
        ]);

        $this->_before_delete(); 
        return $data;
    }

    // 在删除之前
    public function _before_delete() {

        $stmt = self::$pdo->prepare("DELETE FROM role_privlege WHERE role_id=?");
            $stmt->execute([
                $_GET['id'],
            ]);
        

        // var_dump($role_name);
    }


    

}