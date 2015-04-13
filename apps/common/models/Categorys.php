<?php 
namespace Chen\Models;
//分类
class Categorys extends \Phalcon\Mvc\Model
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
    public $cattitle;

     /**
     * @var string
     *		描述
     */
    public $description;

    public function getId()
    {
        return $this->id;
    }


    public function initialize()
    {
        $this->hasMany('id', 'Chen\Models\PostsCategorys', 'categorys_id',array(
            'alias' => 'postscategorys'
        ));
    }
     
}