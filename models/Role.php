<?php
namespace models;

class Role extends Model{

    public function index() {

        $stmt = self::$pdo->prepare("SELECT a.id,a.role_name,GROUP_CONCAT(c.pri_name) pri_list
                                        FROM role a
                                        LEFT JOIN role_privlege b ON a.id=b.role_id
                                        LEFT JOIN privilege c ON b.pri_id=c.id
                                        GROUP BY a.id");
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }
}