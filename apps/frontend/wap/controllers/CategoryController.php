<?php
namespace Chen\Frontend\Wap\Controllers;

use Chen\Models\Categorys;

class CategoryController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
    	$currentPage = $this->request->getQuery("page", "int");

        $CategoryName = urldecode( $this->dispatcher->getParam("category") );
        $CategoryFind = Categorys::findFirst(array("cattitle = '$CategoryName'"));

        if ($CategoryFind != false) {
            
            $posts = array();
            foreach ($CategoryFind->getPostsCategorys(array("order" => "id DESC")) as $PostsCategorys) {
                $posts[] = $PostsCategorys->getPosts();
            }

            $paginator = new \Phalcon\Paginator\Adapter\NativeArray(
                array(
                    "data" => $posts,
                    "limit"=> 10,
                    "page" => $currentPage
                )
            );

            $this->view->postsList = $paginator->getPaginate();
            $this->view->crumbName = $CategoryName;

            $this->tag->appendTitle($CategoryName);
            $this->view->pageDescription = ($CategoryName == $CategoryFind->description) ? '关于'.$CategoryName.'的文章分类' : $CategoryFind->description;
            $this->view->pageKeywords = $CategoryName;
        
        } else {
            return $this->forward('errors/show404');
        }

    }

}