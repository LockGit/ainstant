<?php 
namespace Chen\Models;

use \Phalcon\Tag;

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

    public function initialize()
    {
        $this->hasMany('id', 'Chen\Models\PostsCategorys', 'categorys_id',array(
            'alias' => 'postscategorys'
        ));
    }

    public function getCategorys()
    {
        $categorysFind = self::find();
        $categorys = array();
        foreach ($categorysFind as $category) {
            $catName = $category->cattitle;
            $catUrl = urlencode($catName);
            $categorys[] = Tag::linkTo(array('category/'.$catUrl, $catName, 'title' => $catName));
        }

        return $categorys;
    }

    public function getCatPostCount()
    {
        return count($this->getPostsCategorys());
    }
     
}