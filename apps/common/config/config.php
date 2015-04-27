<?php

/*
*   配置信息
*   2015-1-26
*/
return new \Phalcon\Config(array(

    'site' => array(
        'name'          => '一刻',
        'description'   => '12333',
        'keywords'      => '456',
        'url'           => 'http://ainstant.com',  //  网站域名(不带‘/’)
        'image_url'     => 'http://ainstant.com'   //  图片域名(不带‘/’)
    ),
    //数据库
    'database'    => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'Cheng199410.',
        'dbname'   => 'ainstant',
        'charset'  => 'utf8'
    ),
    //应用信息
    'manage' => array(
        'development'    => array(
            'staticBaseUri' => 'http://ainstant.com/static/',
            'baseUri'       => 'http://ainstant.com/manage/'
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
            'staticBaseUri' => 'http://ainstant.com/static/',
            'baseUri'       => 'http://ainstant.com/'
        ),
        'production'     => array(
            'staticBaseUri' => 'http://example.com/',
            'baseUri'       => '/manage/'
        ),
        'debug'          => true
    )

));
