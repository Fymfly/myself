<?php
namespace controllers;

class PrivilegeController {

    public function index() {

        $model = new \models\Privilege;
        $data = $model->index();
        view('privilege.index',$data);
    }
}