<?php 
namespace Chen\Models;

//类型
class Types extends \Phalcon\Mvc\Model
{
	/**
     * @var integer
     *      id
     */
    public $id;

     /**
     * @var string
     *		名称
     */
    public $typetitle;

     /**
     * @var string
     *		描述
     */
    public $description;


    public function initialize()
    {
        $this->hasMany('id', 'Chen\Models\Posts', 'post_type',array(
            'alias' => 'posts'
        ));
    }  
     
}