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
    
        $paginator = new \Chen\Library\Paginator(
            array(
                'dataFrom' => 'Chen\Models\Posts',
                'limit'    => 10,
                'page'     => $currentPage,
                'cache'    => $this->di->get('config')->cache->frontend->index
            )
        );
        
        $this->view->posts_list = $paginator->getPaginate();

        $this->tag->appendTitle('最美好的那一刻');
        $this->view->pageDescription = $this->di->get('config')->site->description;
        $this->view->pageKeywords = $this->di->get('config')->site->keywords;

    }

}