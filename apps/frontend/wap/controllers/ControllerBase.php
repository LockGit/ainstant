<?php
namespace Chen\Frontend\Wap\Controllers;

use \Phalcon\Mvc\Controller;

use Chen\Models\Categorys;
use Chen\Models\Tags;

class ControllerBase extends Controller
{

    protected function initialize()
    {        
        $this->tag->setTitleSeparator(' | ');
        $this->tag->setTitle('一刻');

        $this->view->categorys = new Categorys();
        $this->view->tags = new Tags();
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