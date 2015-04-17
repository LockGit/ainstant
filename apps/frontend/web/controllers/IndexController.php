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

        $postFind = Posts::find(array("order" => "id DESC"));

        /*
        $cacheKey = 'robots_order_id.cache';
        $postFind = $this->modelsCache->get($cacheKey, 120);
        if ($postFind === null) {

            $postFind = Posts::find(array("order" => "id DESC"));
            $this->modelsCache->save($cacheKey, $postFind);
        }
        */

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $postFind,
                "limit"=> 3,
                "page" => $currentPage
            )
        );

        $this->view->posts_list = $paginator->getPaginate();

        $this->tag->appendTitle('最美好的那一刻');

    }

}