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
        //'url'           => 'http://localhost',  //  网站域名(不带‘/’)
        'url'           => '',  //  网站域名(不带‘/’)
        //'image_url'     => 'http://localhost'   //  图片域名(不带‘/’)
        'image_url'     => ''   //  图片域名(不带‘/’)
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
            //'staticBaseUri' => 'http://localhost/static/',
            'staticBaseUri' => '/static/',
            //'baseUri'       => 'http://localhost/'
            'baseUri'       => '/'
        ),
        'production'     => array(
            'staticBaseUri' => 'http://example.com/',
            'baseUri'       => '/manage/'
        ),
        'debug'          => true
    ),

    //缓存
    'cache' => array(
        'config' => array(

        ),
        'frontend' => array(
            'index' => false
        )
    )

));
