<?php

namespace Chen\Manage\Controllers;
use Chen\Models\Categorys;
use \Phalcon\Mvc\View;

class CatsController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('Sign Up');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->tag->prependTitle('分类');
    }

    public function catlistAction()
    {
        if ($this->request->isPost() == true && $this->request->isAjax()) {
            $currentPage = $this->request->getPost("page", "int");

            $paginator = new \Phalcon\Paginator\Adapter\Model(
                array(
                    "data" => Categorys::find(array("order" => "id DESC")),
                    "limit"=> 10,
                    "page" => $currentPage
                )
            );
     
            $this->view->cats = $paginator->getPaginate();
        } else {
            return $this->response->redirect('cats/index');
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function catformAction()
    {

        if ($this->request->isPost() == true && $this->request->isAjax()) {
            $catId = $this->request->getPost("catId", "int");
            if (!empty($catId)) {

                $catsUpdateFind = Categorys::findFirst($catId);

                if ($catsUpdateFind != false) {

                    $this->tag->setDefault("catId", $catsUpdateFind->id);
                    $this->tag->setDefault("catTitle", $catsUpdateFind->cattitle);
                    $this->tag->setDefault("catDescription", $catsUpdateFind->description);
                }

            }
        } else {
            return $this->response->redirect('cats/index');
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function addAction()
    {
        if ($this->request->isPost() == true && $this->request->isAjax()) {

            $catId = $this->request->getPost('catId');
            $catTitle = $this->request->getPost('catTitle');
            $description = $this->request->getPost('catDescription');

            if (empty($catTitle)) {
                
                echo 'noCatTitle';
            }
            
            if (empty($description)) {
                
                $description = $catTitle;
            }
           
            if (!empty($catTitle) && !empty($description)) {
                
                if (!empty($catId)) {
                   
                    $haveCat = Categorys::findFirst($catId);
                    
                    if ($haveCat != false) {
                        
                        $cats = new Categorys();
                        $cats->id = $catId;
                        $cats->cattitle = $catTitle;
                        $cats->description = $description;

                        if ($cats->save() == false) {
                            
                            echo 'errorUpdate';
                        } else {
                            
                            echo 'successUpdate';
                        }
                    } else {
                        
                        echo 'errorUpdate';
                    }
                } else {
                   
                    $catTitleRepeat = Categorys::findFirst(array("cattitle = '$catTitle'"));

                    if ($catTitleRepeat != false) {

                        echo 'errorHaveCat';
                    } else {
                        
                        $cats = new Categorys();
                        $cats->cattitle = $catTitle;
                        $cats->description = $description;

                        if ($cats->save() == false) {
                            
                            echo 'errorAdd';
                        } else {
                            
                            echo 'successAdd';
                        }
                    }

                }
            }
        } else {
            return $this->response->redirect('cats/index');
        }

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

    //  删除类型
    public function deleteAction()
    {
        
        if ($this->request->isPost() == true && $this->request->isAjax()) {

            $catId = $this->request->getPost("catId", "int");

                $catDeleteFind = Categorys::findFirst($catId);
                if ($catDeleteFind != false) 
                {
                    if ($catDeleteFind->delete() == false) 
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
                    
                    echo 'noCat';
                }

            
        } else {
            return $this->response->redirect('cats/index');
        }

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }
}