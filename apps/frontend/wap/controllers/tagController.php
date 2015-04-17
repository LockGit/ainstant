<?php
namespace Chen\Frontend\Wap\Controllers;

use Chen\Models\Tags;

class tagController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
    	$currentPage = $this->request->getQuery("page", "int");

        $TagName = urldecode( $this->dispatcher->getParam("tag") );
        $TagFind = Tags::findFirst(array("tagtitle = '$TagName'"));
        
        if ($TagFind != false) {
       
            $posts = array();
            foreach ($TagFind->getPostsTags(array("order" => "id DESC")) as $PostsTags) {
                $posts[] = $PostsTags->getPosts();
            }

            if (empty($posts)) {
                return $this->forward('errors/show404');
            }

            $paginator = new \Phalcon\Paginator\Adapter\NativeArray(
                array(
                    "data" => $posts,
                    "limit"=> 10,
                    "page" => $currentPage
                )
            );

            $this->view->postsList = $paginator->getPaginate();
            $this->view->crumbName = $TagName;

            $this->tag->appendTitle($TagName);
        
        } else {
            return $this->forward('errors/show404');
        }

    }

}