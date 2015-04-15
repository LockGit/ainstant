<?php
namespace Chen\Frontend\Web\Controllers;

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

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => Posts::find(array("order" => "id DESC")),
                "limit"=> 10,
                "page" => $currentPage
            )
        );

        $this->view->posts_list = $paginator->getPaginate();

        $this->tag->appendTitle('最美好的那一刻');

    }

}