<?php
namespace controllers;

use \models\Role;

class RoleController extends BaseController{

    // 显示角色管理页面
    public function index() {

        $model = new \models\Role;
        $data = $model->index();

        // var_dump('sdfsd');
        view('role.index',$data);
    }

    
    // 处理添加表单 
    public function doAdd() {

        $role_name = $_POST['role_name'];

        $model = new \models\Role;
        $model->add($role_name);
        // var_dump($role_name);

        redirect('/role/index');
    }

    // 显示添加页面
    public function create() {

        $priModel = new \models\privilege;
        $data = $priModel->tree();

        // var_dump('<pre>');
        // var_dump($data);

        view('role.create',$data);
    }

    // 显示修改的表单
    public function edit() {

        $model = new Role;
        $data = $model->edit($_GET['id']);

        // echo "<pre>";
        // var_dump($data);die;
        // 取出权限的数据
        $priModel = new \models\privilege;
        // 获取树形数据（递归排序）
        $priData = $priModel->tree();

        // 取出这个角色所拥有的权限id
        $priIds = $model->getPriIds($_GET['id']);

        view('role/edit',[
            'data' => $data,
            'priData' => $priData,
            'priIds' => $priIds,
        ]);
    }

    // 处理修改的表单
    public function update() {

        $roleId = $_GET['id'];
        $role_name = $_POST['role_name'];
        
        $model = new Role; 
        $model->update($role_name,$roleId);

       
        // var_dump($roleId,$role_name);
        // var_dump('jhjk');

        redirect('/role/index');
    }

    // 删除
    public function delete() {

        // $role_id = $_POST['id'];

        $model = new \models\Role;
        $model->delete($_GET['id']);
        redirect('/role/index');
    }
}