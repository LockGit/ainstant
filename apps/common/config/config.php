<?php

/*
*   配置信息
*   2015-1-26
*/
return new \Phalcon\Config(array(

    'site' => array(
        'name'      => '一刻',
        'url'       => 'http://localhost',  //  网站域名(不带‘/’)
        'image_url' => 'http://localhost'   //  图片域名(不带‘/’)
    ),
    //数据库
    'database'    => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'shimmer',
        'charset'  => 'utf8'
    ),
    //应用信息
    'manage' => array(
        'development'    => array(
            'staticBaseUri' => 'http://localhost/static/',
            'baseUri'       => 'http://localhost/manage/'
        ),
        'production'     => array(
            'staticBaseUri' => 'http://example.com/',
            'baseUri'       => '/manage/'
        ),
        'debug'          => true
    ),

    //应用信息
    'frontend' => array(
        'development'    => array(
            'staticBaseUri' => 'http://localhost/static/',
            'baseUri'       => 'http://localhost/'
        ),
        'production'     => array(
            'staticBaseUri' => 'http://example.com/',
            'baseUri'       => '/manage/'
        ),
        'debug'          => true
    )

));
