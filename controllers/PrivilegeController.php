<?php
namespace controllers;

class PrivilegeController {

    public function index() {

        $model = new \models\Privilege;
        $data = $model->tree();
        
        view('privilege.index',$data);
    }
}