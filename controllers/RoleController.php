<?php
namespace controllers;

use \models\Role;

class RoleController {

    public function index() {

        $model = new \models\Role;
        $data = $model->index();

        // var_dump('sdfsd');

        view('role.index',$data);
    }
}