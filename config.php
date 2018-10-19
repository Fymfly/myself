<?php
return [
    'mode' => 'dev',   // dev (开发模式)   pro (上线模式)
    'redis' => [
        'scheme' => 'tcp',
        'host'   => '127.0.0.1',
        'port'   => 6379,
    ],
    'db' => [
        'host' => '127.0.0.1',
        'dbname' => 'myblog',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8',
    ],
    'email' => [
        'mode'=>'debug',    // debug：调试模式、    production：生产模式
        'port' => 25,
        'host' => 'smtp.126.com',
        'name' => 'czxy_qz@126.com',
        'pass' => '12345678abcdefg',
        'from_email' => 'czxy_qz@126.com',
        'from_name' => '全栈1班',
    ]
];


// insert into privilege(id,pri_name,url_path,parent_id) VALUES
// (1,'常用操作','',0),
//     (2,'作品管理','blog/design',1),
//         (3,'添加作品','blog/insert,blog/store',2),
//         (4,'修改作品','blog/edit,blog/store',2),
//         (5,'删除作品','blog/delete',2),
//     (6,'分类管理','classify/index/',1),
//         (7,'添加分类','classify/index,classify/insert',6),
//         (8,'修改分类','classify/edit,classify/store',6),
//         (9,'删除分类','classify/delete/',6),
//     (10,'图片管理','tupian/index',1),
//         (11,'添加图片','tupian/create,tupian/uploadall',10),
//         (12,'修改图片','tupian/edit,tupian/uploadall',10),
//         (13,'删除图片','tupian/delete',10),
// (14,'权限模块','',0),
//     (15,'权限管理','privilege/index',14),
//         (16,'添加权限','privilege/create,privilege/insert',15),
//         (17,'修改权限','privilege/edit,privilege/store',15),
//         (18,'删除权限','privilege/delete',15),
//     (19,'角色管理','role/index',14),
//         (20,'添加角色','role/create,role/doAdd',19),
//         (21,'修改角色','role/edit,role/store',19),
//         (22,'删除角色','role/delete',19),
//     (23,'管理员管理','admin/index',14),
//         (24,'添加管理员','admin/create,role/doAdd',23),
//         (25,'修改管理员','admin/edit,role/store',23),
//         (26,'删除管理员','admin/delete',23);
    