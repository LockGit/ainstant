<?php
namespace Chen\Frontend\Web\Controllers;

use \Phalcon\Mvc\View;

class ErrorsController extends ControllerBase
{

	public function initialize()
    {
        $this->tag->setTitle('Sign Up');
        parent::initialize();

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function show404Action()
    {
     	$this->tag->prependTitle('404');
    }

    public function show500Action()
    {
    	$this->tag->prependTitle('500');
    }

}