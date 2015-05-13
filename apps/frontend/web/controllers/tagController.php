<?php
namespace Chen\Frontend\Web\Controllers;

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
            
            $paginator = new \Chen\Frontend\Library\CatPaginator(
                array(
                    'dataFrom' => 'PostsTags',
                    'dataFromId' => 'tags_id = '.$TagFind->id,
                    'limit'    => 10,
                    'page'     => $currentPage
                )
            );

            $this->view->posts_list = $paginator->getPaginate();
            $this->view->crumbName = $TagName;

            $this->tag->prependTitle($TagName);
            $this->view->pageDescription = ($TagName == $TagFind->description) ? '关于'.$TagName.'的文章分类' : $TagFind->description;
            $this->view->pageKeywords = $TagName;
        
        } else {
            return $this->forward('errors/show404');
        }

    }

}