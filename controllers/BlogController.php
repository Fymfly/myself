<?php
namespace controllers;

use PDO;
use \models\Blog;

class BlogController extends BaseController{

    // 三级联动（获取子分类）
    public function ajax_get_cat() {

        $parent_id = (int)$_GET['id'];

        // 根据这个id查询子分类
        $model = new \models\Classify;
        $data = $model->getCat($parent_id);
        // var_dump($data);die;
        // 转成 JSON
        echo json_encode($data);
    }

    // 显示添加视图
    public function insert() {
        $model = new \models\Classify;
        $data = $model->getCat();
        view('blog.insert',$data);
    }

    // 处理添加表单
    public function store() {
        // $image = $_FILES['image'];
        $model = new Blog;
        $image = $model->image();
        // $image = $this->image();
        $title = $_POST['title'];
        $content = $_POST['content'];
        $classify_id = $_POST['classify'];

        // var_dump($image);
        // die;
        // var_dump($user_id);
        $blog = new Blog;
        $blog->add($title,$content,$image,$classify_id);
        // 跳转
        redirect('/blog/design');
    }
    
    public function design() {

        // $model = new Blog;
        // $data = $model->Dodata();
        
        $model = new Blog;
        $data = $model->search();
        // var_dump('<pre>');
        // var_dump($data);die;
        
        // var_dump($search);
        // die;

        
    
        view('blog.design',$data);
    }

    public function delete() {

        $id = $_GET['id'];

        $blog = new Blog;

        $blog->delete($id);

        redirect('/blog/design');
        // echo "删除成功";

    }


    // 显示修改视图
    public function edit() {

        $blogId = $_GET['id'];
        $model = new Blog;
        $data = $model->findOne($blogId);

        view('blog.edit',$data);
    }

    // 修改日志
    public function update() {

        $blogId = $_GET['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        // var_dump($blogId);
        // die;

        $model = new Blog;
        $model->update($blogId,$title,$content);
        redirect('/blog/design');
    }
}