<?php
namespace Chen\Manage\Controllers;

class ErrorsController extends ControllerBase
{

	public function initialize()
    {
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