<?php
namespace Chen\Frontend\Wap\Controllers;

use \Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{


    protected function initialize()
    {
        
        $this->tag->prependTitle('EVEVCASE | ');
        //$this->view->setTemplateAfter('main');
    }


}