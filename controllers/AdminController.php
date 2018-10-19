<?php
namespace controllers;

class AdminController extends BaseController{

    public function index() {

        $model = new \models\Admin;
        $data = $model->index();

        view('admin.index',$data);
    }
}