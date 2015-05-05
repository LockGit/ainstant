<?php
namespace Chen\Frontend\Wap\Controllers;

use Chen\Models\Posts;

class SearchController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
    	$search = $this->request->getQuery('s');

        if (empty($search)) {
            return $this->forward('index');
        }

        $query = $search;

        $phql = "SELECT * FROM Chen\Models\Posts WHERE post_content LIKE '%$query%' OR
            post_excerpt LIKE '%$query%' OR post_title LIKE '%$query%' ORDER BY id";
        $posts = $this->modelsManager->executeQuery($phql);

        $currentPage = $this->request->getQuery("page", "int");

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $posts,
                "limit"=> 10,
                "page" => $currentPage
            )
        );

        $this->view->postsList = $paginator->getPaginate();
        $this->view->search = $search;

        $this->tag->prependTitle($search.' 的搜索结果');
        $this->view->pageDescription = $search;
        $this->view->pageKeywords = $search;

    }

}