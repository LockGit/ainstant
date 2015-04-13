<?php
namespace Chen\Models;

class PostsCategorys extends \Phalcon\Mvc\Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $posts_id;

    /**
     * @var integer
     */
    public $categorys_id;


    public function initialize()
    {
        $this->belongsTo('posts_id', 'Chen\Models\Posts', 'id',array(
            'alias' => 'posts'
        ));
        $this->belongsTo('categorys_id', 'Chen\Models\Categorys', 'id',array(
            'alias' => 'categorys'
        ));
    }

}