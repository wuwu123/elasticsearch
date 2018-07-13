<?php

require_once "./../vendor/autoload.php";

$model = new \Jie\ContentService(['url' => '120.27.110.172']);
$selectModel = new \Jie\SearchService(['url' => '120.27.110.172']);
$table = [ //文档类型设置（相当于mysql的数据类型）
    'id'      => [
        'type' => 'integer',
    ],
    'select'  => [
        'type'  => 'text',
        'store' => 'true',
    ],
    'keyword' => [
        'type' => 'keyword',
    ]
];
//$data  = $model->getDesc("wujie");
//$data  = $model->updateMappings("wujie", "wujie", $table);
//print_r($model->create("wujie", "wujie", $table));
//var_dump($model->exit("wujie"));
//var_dump($model->delete("wujie"));
//$data = $model->addData("wujie", "wujie", ["select" => "哈哈哈", "keyword" => "我是武杰"]);
//$data = $model->deleteRow("wujie", "wujie", 3);
//$data = $model->get("wujie", "wujie", 3);
$data = $selectModel->match("wujie" , "wujie");
//$data = $selectModel->matchAll("wujie" , "wujie");
echo "<pre>";
print_r($data);
echo "</pre>";
exit();