<?php
namespace Chen\Frontend\Web\Controllers;

use \Phalcon\Mvc\Controller;
use \Phalcon\Mvc\View;
use Chen\Models\Posts;
use Chen\Models\Categorys;
use Chen\Models\Tags;

class ControllerBase extends Controller
{

    protected function initialize()
    {
        
        $this->tag->setTitleSeparator(' | ');
        $this->tag->setTitle($this->di->get('config')->site->name);

        $this->view->post = new Posts();
        $this->view->categorys = new Categorys();
        $this->view->tags = new Tags();

        if ($this->is_pjax()) {
        	$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }
    }

    protected function is_pjax(){
        return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];
    }

    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1]
            )
        );
    } 

}