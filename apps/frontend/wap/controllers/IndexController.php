<?php
namespace Chen\Frontend\Wap\Controllers;

use Chen\Models\Posts;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
    	$currentPage = $this->request->getQuery("page", "int");

        $postFind = Posts::find(array("order" => "id DESC"));

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $postFind,
                "limit"=> 10,
                "page" => $currentPage
            )
        );

        $this->view->postsList = $paginator->getPaginate();

        $this->tag->appendTitle('最美好的那一刻');
        $this->view->pageDescription = $this->di->get('config')->site->description;
        $this->view->pageKeywords = $this->di->get('config')->site->keywords;

    }

}