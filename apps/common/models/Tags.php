<?php 
namespace Chen\Models;

use \Phalcon\Tag;
//类型
class Tags extends \Phalcon\Mvc\Model
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
    public $tagtitle;

     /**
     * @var string
     *		描述
     */
    public $description;

    public function initialize()
    {

        $this->hasMany('id', 'Chen\Models\PostsTags', 'tags_id',array(
            'alias' => 'poststags'
        ));

    }

    public function getTagName()
    {
        return $this->tagtitle;
    }

    public function getTags()
    {
        $tagsFind = self::find();
        $tags = array();
        foreach ($tagsFind as $tag) {
            $tagName = $tag->tagtitle;
            $tagUrl = urlencode($tagName);
            $tags[] = Tag::linkTo(array('tag/'.$tagUrl, $tagName, 'rel' => 'nofollow', 'title' => $tag->getTagPostCount().' 个话题'));
        }

        return $tags;
    }

    public function getTagPostCount()
    {
        //return count($this->getPostsTags());
    }
}