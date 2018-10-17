<?php
namespace models;

class Privilege extends Model{

    public function index() {

        $stmt = self::$pdo->prepare("SELECT * FROM privilege");
        $stmt->execute();
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );

        return $data;
    }

    // 递归树形结构的数据
    public function tree()
    {
        // 先取出所有的权限
        $data = $this->index();

        // var_dump($data);
        // 递归重新排序
        $ret = $this->_tree($data);
        // var_dump($ret);
        return $ret;
    }

    // 递归排序（本类和子本可以调用（protected））
    // 参数一、排序的数据
    // 参数二、上级ID
    // 参数三、第几级
    public function _tree($data, $parent_id=0, $level=0)
    {
        // 定义一个数组保存排序好之后的数据
        // var_dump($data);
        static $_ret = [];
        foreach($data as $v)
        {
            if($v['parent_id'] == $parent_id)
            {
                // 标签它的级别
                $v['level'] = $level;
                // 挪到排序之后的数组中
                $_ret[] = $v;
                // 找 $v 的子分类
                $this->_tree($data, $v['id'], $level+1);
            }
        }
        // 返回排序好的数组
        return $_ret;
    }
}