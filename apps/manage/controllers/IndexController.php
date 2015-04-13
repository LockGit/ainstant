<?php

namespace Chen\Manage\Controllers;

use \Phalcon\Mvc\View;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }


    public function indexAction()
    {
        //$this->flash->error('Wrong email/password');
        //$this->flashSession->success("Your information was stored correctly!");

        
        //$post = PostsCategorys::findfirst(1);
        //$post = Tags::findFirst(1);
        //$post = "12345";
        //$post = $this->di->get('config')->database->host;
        //$post = APP_PATH . $config->database->host;
        //$this->view->setVar("post_category", $post);

        //$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $this->tag->prependTitle('首页');
    }

    public function mainAction()
    {
        $this->flash->notice('Wrong email/password');
        $this->flash->success('Wrong email/password');
        $this->flash->warning('Wrong email/password');
        $this->flash->error('Wrong email/password');

    }

}