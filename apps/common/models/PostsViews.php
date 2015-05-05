<?php
namespace Chen\Models;

class PostsViews extends \Phalcon\Mvc\Model
{
	/**
     * @var integer
     *      id
     */
    public $id;

    /**
     * @var integer
     *      id
     */
    public $post_id;

    /**
     * @var string
     *      浏览次数
     */
    public $post_view;

    public function initialize()
    {
    	$this->hasOne('post_id', 'Chen\Models\Posts', 'id',array(
            'alias' => 'posts'
        ));

        $this->skipAttributesOnUpdate(array('post_id'));
    }
}