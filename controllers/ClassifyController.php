<?php
namespace controllers;

class ClassifyController {

    // 显示视图
    public function index() {

        $model = new \models\Classify;
        $data = $model->index([
            'order_by' => 'concat(path,id,"-")',
            'order_way' => 'asc',
            'per_page' => 99999999,     // 不翻页
        ]);

        view('classify.index',$data);
    }
}