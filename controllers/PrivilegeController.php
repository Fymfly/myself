<?php
namespace controllers;

class PrivilegeController extends BaseController{

    public function index() {

        $model = new \models\Privilege;
        $data = $model->tree();
        
        view('privilege.index',$data);
    }
}