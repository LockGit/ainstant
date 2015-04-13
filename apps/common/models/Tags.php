<?php 
namespace Chen\Models;
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

    public function getTagUrl()
    {        
        return $tagUrl = APP_URL.'/tag/'.urlencode($this->tagtitle);     
    }

    public function getTagPostCount()
    {
        return count($this->getPostsTags());
    }
}