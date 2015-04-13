<?php

namespace Chen\Manage\Controllers;
use Chen\Models\Tags;
use \Phalcon\Mvc\View;

class TagsController extends ControllerBase
{

	public function initialize()
    {
        $this->tag->setTitle('Sign Up');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->tag->prependTitle('标签');
    }

    public function taglistAction()
    {
        if ($this->request->isPost() == true && $this->request->isAjax()) {
            $currentPage = $this->request->getPost("page", "int");

            $paginator = new \Phalcon\Paginator\Adapter\Model(
                array(
                    "data" => Tags::find(array("order" => "id DESC")),
                    "limit"=> 10,
                    "page" => $currentPage
                )
            );
     
            $this->view->tags = $paginator->getPaginate();
        } else {
            return $this->response->redirect('tags/index');
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function tagformAction()
    {
        if ($this->request->isPost() == true && $this->request->isAjax()) {
            $tagId = $this->request->getPost("tagId", "int");
            if (!empty($tagId)) {

                $tagsUpdateFind = Tags::findFirst($tagId);

                if ($tagsUpdateFind != false) {

                    $this->tag->setDefault("tagId", $tagsUpdateFind->id);
                    $this->tag->setDefault("tagTitle", $tagsUpdateFind->tagtitle);
                    $this->tag->setDefault("tagDescription", $tagsUpdateFind->description);
                }

            }
        } else {
            return $this->response->redirect('tags/index');
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
    
    public function addAction()
    {
        
        if ($this->request->isPost() == true && $this->request->isAjax()) {
            
            $tagId = $this->request->getPost('tagId');
            $tagTitle = $this->request->getPost('tagTitle');
            $description = $this->request->getPost('tagDescription');

            if (empty($tagTitle)) {
                
                echo 'noTagTitle';
            }
            
            if (empty($description)) {
                
                $description = $tagTitle;
            }
           
            if (!empty($tagTitle) && !empty($description)) {
                
                if (!empty($tagId)) {
                   
                    $haveTag = Tags::findFirst($tagId);
                    
                    if ($haveTag != false) {
                        
                        $tags = new Tags();
                        $tags->id = $tagId;
                        $tags->tagtitle = $tagTitle;
                        $tags->description = $description;

                        if ($tags->save() == false) {
                            
                            echo 'errorUpdate';
                        } else {
                            
                            echo 'successUpdate';
                        }
                    } else {
                        
                        echo 'errorUpdate';
                    }
                } else {
                   
                    $tag_title_repeat = Tags::findFirst(array("tagtitle = '$tagTitle'"));

                    if ($tag_title_repeat != false) {

                        echo 'errorHaveTag';
                    } else {
                        
                        $tags = new Tags();
                        $tags->tagtitle = $tagTitle;
                        $tags->description = $description;

                        if ($tags->save() == false) {
                            
                            echo 'errorAdd';
                        } else {
                            
                            echo 'successAdd';
                        }
                    }

                }
            }
            

        } else {
            return $this->response->redirect('tags/index');
        }

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    
    }

    public function deleteAction()
    {
        
        if ($this->request->isPost() == true && $this->request->isAjax()) {

            $tagId = $this->request->getPost("tagId", "int");

                $tagDeleteFind = Tags::findFirst($tagId);
                if ($tagDeleteFind != false) 
                {
                    if ($tagDeleteFind->delete() == false) 
                    {
            
                        echo 'errorDelete';
                    } 
                    else 
                    {
                        
                        echo 'successDelete';
                    }
                } 
                else 
                {
                    
                    echo 'noTag';
                }

            
        } else {
            return $this->response->redirect('tags/index');
        }

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }
}