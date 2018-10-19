<?php
namespace controllers;

use models\User;

class UserController extends BaseController{

    public function hello() {

        $model = new User;
        $name = $model->getName();

        return view('index.index',[

            'name' => $name,

        ]);
    }
}