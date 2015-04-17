<?php
namespace Chen\Frontend\Wap\Controllers;

class ErrorsController extends ControllerBase
{

	public function initialize()
    {
        $this->tag->setTitle('Sign Up');
        parent::initialize();

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