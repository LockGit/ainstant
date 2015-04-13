<?php
namespace Chen\Models;

class PostsTags extends \Phalcon\Mvc\Model
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
    public $tags_id;


    public function initialize()
    {
        $this->belongsTo('posts_id', 'Chen\Models\Posts', 'id',array(
            'alias' => 'posts'
        ));
        $this->belongsTo('tags_id', 'Chen\Models\Tags', 'id',array(
            'alias' => 'tags'
        ));
    }

}