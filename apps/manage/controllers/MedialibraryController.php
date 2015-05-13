<?php
namespace Chen\Manage\Controllers;

use \Phalcon\Mvc\View;
use Chen\Models\Files;

class MedialibraryController extends ControllerBase
{

	public function initialize()
    {
        $this->tag->setTitle('Sign Up');
        parent::initialize();
    }

    public function indexAction()
    {
        
        $currentPage = $this->request->getQuery("page", "int");

        $paginator = new \Chen\Library\Paginator(
            array(
                'dataFrom' => 'Chen\Models\Files',
                'limit'    => 24,
                'page'     => $currentPage,
                'condition'=> 'file_type = 1'
            )
        );

        $file_list_page = $paginator->getPaginate();

        $this->view->fileListPage = $file_list_page;

        if ($this->request->isAjax()) {
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }

        $this->tag->prependTitle('媒体库');

    }

    public function addAction()
    {
        $this->tag->prependTitle('添加');
    }

    public function uploadAction()
    {
        
        // Check if the user has uploaded files
        if ($this->request->hasFiles() == true) {

            // Print the real file names and sizes
            foreach ($this->request->getUploadedFiles() as $file) {
                //  获取文件的MD5
                $filesModels = new Files();
                $fileInfo = $filesModels->uploadFiles($file);
               
                $movePath = $fileInfo['movePath'];
                $fileUrl = $fileInfo['fileUrl'];
                                               
                if(file_exists($movePath)) {                    
                    $jsonReturn = array(
                        'success' => 'true',
                        'msg' => '上传成功',
                        'file_path' => $fileUrl
                    );
                    $this->response->setContentType('application/json', 'utf-8');
                    echo json_encode($jsonReturn);                 
                } else {
                    $jsonReturn = array(
                        'success' => 'false',
                        'msg' => '上传失败'
                    );
                    $this->response->setContentType('application/json', 'utf-8');
                    echo json_encode($jsonReturn);  
                }
                            
            }
        }

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

    public function postaddpictureAction()
    {
        $currentPage = $this->request->getQuery("page", "int");
        
        $paginator = new \Chen\Library\Paginator(
            array(
                'dataFrom' => 'Chen\Models\Files',
                'limit'    => 24,
                'page'     => $currentPage,
                'condition'=> 'file_type = 1'
            )
        );

        $fileListPage = $paginator->getPaginate();

        $this->view->fileListPage = $fileListPage;

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function postaddthumbnailAction()
    {
        $currentPage = $this->request->getQuery("page", "int");
        
        $paginator = new \Chen\Library\Paginator(
            array(
                'dataFrom' => 'Chen\Models\Files',
                'limit'    => 24,
                'page'     => $currentPage,
                'condition'=> 'file_type = 1'
            )
        );

        $file_list_page = $paginator->getPaginate();

        $this->view->fileListPage = $file_list_page;

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function imageAction()
    {
        header('content-type: image/png');

        $image = new \Phalcon\Image\Adapter\GD("upload/temp/733181708fe67fe6888be35ef782d1df-720x500.jpg");
        //$image->resize(200, 200)->rotate(90)->crop(100, 100);

        echo $image->render();


        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

}