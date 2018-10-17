<?php
namespace controllers;

use \models\Role;

class RoleController {

    // 显示角色管理页面
    public function index() {

        $model = new \models\Role;
        $data = $model->index();

        // var_dump('sdfsd');
        view('role.index',$data);
    }

    
    // 处理添加表单 

    // 显示添加页面
    public function create() {

        $priModel = new \models\privilege;
        $data = $priModel->tree();

        // var_dump('<pre>');
        // var_dump($data);

        view('role.create',$data);
    }
}