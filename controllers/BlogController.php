<?php
namespace controllers;

use PDO;
use \models\Blog;

class BlogController {

    public function store() {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_POST['user_id'];
        var_dump($user_id);
        $blog = new Blog;
        $blog->add($title,$content,$user_id);

        // 跳转
        redirect('/blog/design');

    }

    public function design() {

        $model = new Blog;
        $data = $model->Dodata();

        // var_dump($data);
    
        view('blog.design',[
            'data' => $data,
        ]);
    }

    public function delete() {

        $id = $_GET['id'];

        $blog = new Blog;

        $blog->delete($id);

        redirect('/blog/design');
        // echo "删除成功";

    }

    public function insert() {

        view('blog.insert');
    }

    public function edit() {

        view('blog.edit');
    }
}