<?php

namespace Chen\Manage\Controllers;
use Chen\Models\Types;
use \Phalcon\Mvc\View;

class TypesController extends ControllerBase
{

	public function initialize()
    {
        $this->tag->setTitle('Sign Up');
        parent::initialize();
    }

    public function indexAction()
    {
     	$this->tag->prependTitle('类型');
    }

    public function typelistAction()
    {
        if ($this->request->isPost() == true && $this->request->isAjax()) {
            $currentPage = $this->request->getPost("page", "int");

            $paginator = new \Chen\Library\Paginator(
                array(
                    'dataFrom' => 'Chen\Models\Types',
                    'limit'    => 2,
                    'page'     => $currentPage,
                )
            );
     
            $this->view->types = $paginator->getPaginate();
        } else {
            return $this->response->redirect('types/index');
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function typeformAction()
    {

        if ($this->request->isPost() == true && $this->request->isAjax()) {
            $typeId = $this->request->getPost("typeId", "int");
            if (!empty($typeId)) {

                $typesUpdateFind = Types::findFirst($typeId);

                if ($typesUpdateFind != false) {

                    $this->tag->setDefault("typeId", $typesUpdateFind->id);
                    $this->tag->setDefault("typeTitle", $typesUpdateFind->typetitle);
                    $this->tag->setDefault("typeDescription", $typesUpdateFind->description);
                }

            }
        } else {
            return $this->response->redirect('types/index');
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function addAction()
    {
        if ($this->request->isPost() == true && $this->request->isAjax()) {

            $typeId = $this->request->getPost('typeId');
            $typeTitle = $this->request->getPost('typeTitle');
            $description = $this->request->getPost('typeDescription');

            if (empty($typeTitle)) {
                
                echo 'noTypeTitle';
            }
            
            if (empty($description)) {
                
                $description = $typeTitle;
            }
           
            if (!empty($typeTitle) && !empty($description)) {
                
                if (!empty($typeId)) {
                   
                    $haveType = Types::findFirst($typeId);
                    
                    if ($haveType != false) {
                        
                        $types = new Types();
                        $types->id = $typeId;
                        $types->typetitle = $typeTitle;
                        $types->description = $description;

                        if ($types->save() == false) {
                            
                            echo 'errorUpdate';
                        } else {
                            
                            echo 'successUpdate';
                        }
                    } else {
                        
                        echo 'errorUpdate';
                    }
                } else {
                   
                    $tagTitleRepeat = Types::findFirst(array("typetitle = '$typeTitle'"));

                    if ($tagTitleRepeat != false) {

                        echo 'errorHaveType';
                    } else {
                        
                        $types = new Types();
                        $types->typetitle = $typeTitle;
                        $types->description = $description;

                        if ($types->save() == false) {
                            
                            echo 'errorAdd';
                        } else {
                            
                            echo 'successAdd';
                        }
                    }

                }
            }
        } else {
            return $this->response->redirect('types/index');
        }

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

    //  删除类型
    public function deleteAction()
    {
    	
        if ($this->request->isPost() == true && $this->request->isAjax()) {

            $typeId = $this->request->getPost("typeId", "int");

                $typeDeleteFind = Types::findFirst($typeId);
                if ($typeDeleteFind != false) 
                {
                    if ($typeDeleteFind->delete() == false) 
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
                    
                    echo 'noType';
                }

            
        } else {
            return $this->response->redirect('types/index');
        }

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }
}