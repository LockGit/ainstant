<?php

/*
*   配置信息
*   2015-1-26
*/
return new \Phalcon\Config(array(

    'site' => array(
        'name'      => '一刻',
        'url'       => ''
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
            'staticBaseUri' => '/static/',
            'baseUri'       => '/manage/'
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
            'staticBaseUri' => '/static/',
            'baseUri'       => '/'
        ),
        'production'     => array(
            'staticBaseUri' => 'http://example.com/',
            'baseUri'       => '/manage/'
        ),
        'debug'          => true
    )

));
