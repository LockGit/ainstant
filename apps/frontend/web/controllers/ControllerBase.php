<?php
namespace Chen\Frontend\Web\Controllers;

use \Phalcon\Mvc\Controller;
use \Phalcon\Mvc\View;

class ControllerBase extends Controller
{


    protected function initialize()
    {
        
        //设置标题分离器
        $this->tag->setTitleSeparator(' | ');
        //$this->tag->prependTitle('一刻');
        //$this->tag->appendTitle('Shimmer'); 
        $this->tag->setTitle('一刻');

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