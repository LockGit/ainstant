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

        $paginator = new \Chen\Library\Paginator(
            array(
                'dataFrom' => 'Chen\Models\Posts',
                'limit'    => 10,
                'page'     => $currentPage
            )
        );

        $this->view->postsList = $paginator->getPaginate();

        $this->tag->appendTitle($this->di->get('config')->site->title);
        $this->view->pageDescription = $this->di->get('config')->site->description;
        $this->view->pageKeywords = $this->di->get('config')->site->keywords;

    }

}