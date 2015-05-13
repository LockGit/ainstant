<?php
namespace Chen\Frontend\Web\Controllers;

use Chen\Models\Categorys;
use Chen\Models\PostsCategorys;

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
            
            $paginator = new \Chen\Frontend\Library\CatPaginator(
                array(
                    'dataFrom' => 'PostsCategorys',
                    'dataFromId' => 'categorys_id = '.$CategoryFind->id,
                    'limit'    => 10,
                    'page'     => $currentPage
                )
            );

            $this->view->posts_list = $paginator->getPaginate();
            $this->view->crumbName = $CategoryName;

            $this->tag->prependTitle($CategoryName);
            $this->view->pageDescription = ($CategoryName == $CategoryFind->description) ? '关于'.$CategoryName.'的文章分类' : $CategoryFind->description;
            $this->view->pageKeywords = $CategoryName;
        
        } else {
            return $this->forward('errors/show404');
        }

    }

}