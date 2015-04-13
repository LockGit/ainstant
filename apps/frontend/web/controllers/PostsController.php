<?php
namespace Chen\Frontend\Web\Controllers;

use Chen\Models\Posts;

class PostsController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }


    public function indexAction()
    {
        $post_id = $this->dispatcher->getParam("post");
        
        $post = Posts::findFirstById($post_id);

        if ($post != false) {
            $this->view->post = $post;
        } else {
            return $this->forward('errors/show404');
        }

        $this->tag->prependTitle($post->getPostTitle(20));       

    }

}