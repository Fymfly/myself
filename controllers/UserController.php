<?php
namespace controllers;

use models\User;

class UserController {

    public function hello() {

        $model = new User;
        $name = $model->getName();

        return view('index.index',[

            'name' => $name,

        ]);
    }
}