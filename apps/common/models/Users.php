<?php
namespace Chen\Models;
//用户
class Users extends \Phalcon\Mvc\Model
{
	/**
     * @var integer
     *      用户id
     */
    public $id;

     /**
     * @var string
     *		用户名
     */
    public $username;

     /**
     * @var string
     *		密码
     */
    public $password;

     /**
     * @var string
     *		email
     */
    public $email;

     /**
     * @var string
     *		昵称
     */
    public $nicename;

     /**
     * @var string
     *		描述
     */
    public $description;

     /**
     * @var datetime
     *      注册时间
     */
    public $rigistered;

     /**
     * @var string
     *		用户分组
     */
    public $usergroup;


    public function initialize()
    {
        $this->hasMany('id', 'Chen\Models\Posts', 'post_author',array(
            'alias' => 'posts'
        ));
    }

}