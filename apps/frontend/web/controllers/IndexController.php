<?php
namespace Chen\Frontend\Web\Controllers;

use Chen\Models\Posts;
use Chen\Models\Tags;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }


    public function indexAction()
    {
    	$currentPage = $this->request->getQuery("page", "int");

        $posts_list_find = Posts::find(array("order" => "id DESC"));

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $posts_list_find,
                "limit"=> 2,
                "page" => $currentPage
            )
        );
 
        $posts_lists = $paginator->getPaginate();

        $this->view->posts_list = $posts_lists;
        $this->view->post = new Posts();
        $this->view->tags = Tags::find();

        $this->tag->appendTitle('最美好的那一刻');

    }

    

}