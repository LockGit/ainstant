<?php
namespace Chen\Frontend\Web\Controllers;

use Chen\Models\Posts;
use \Phalcon\Mvc\View;

class PostController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }


    public function indexAction()
    {
        $post_id = $this->dispatcher->getParam("post","int");
        
        $post = Posts::findFirstById($post_id);

        if ($post != false) {
            $this->view->post = $post;
        } else {
            return $this->forward('errors/show404');
        }

        $this->view->crumbName = $post->getPostTitle(20);
        
        $this->tag->prependTitle($post->getPostTitle(20));
        $this->view->pageDescription = (!empty($post->post_description)) ? $post->post_description : $post->getPostExcerpt();
        $this->view->pageKeywords = (!empty($post->post_keywords)) ? $post->post_keywords : $post->getPostTag().','.$post->getPostCategory();       

    }

    public function feedAction()
    {
        $this->response->setContentType('text/xml', 'utf-8');
        
        $this->view->posts = Posts::find(array('order' => 'id DESC', 'limit' => 10));

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

}