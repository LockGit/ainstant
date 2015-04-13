<?php
namespace Chen\Frontend\Wap\Controllers;

use \Phalcon\Mvc\View;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('主页');
        parent::initialize();
    }


    public function indexAction()
    {
       
    }

    

}