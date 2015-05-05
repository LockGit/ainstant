<?php

namespace Chen\Manage\Controllers;

use \Phalcon\Mvc\View;
use Chen\Models\Posts;
use Chen\Models\PostsCategorys;
use Chen\Models\PostsTags;
use Chen\Models\Types;
use Chen\Models\Categorys;
use Chen\Models\Tags;
use Chen\Models\Files;

class PostsController extends ControllerBase
{

	public function initialize()
    {
        parent::initialize();
    }

    //文章列表
    public function indexAction()
    {
        $this->tag->prependTitle('文章列表');
    }

    public function postlistAction()
    {
        if ($this->request->isPost() == true && $this->request->isAjax()) {

            $currentPage = $this->request->getPost("page", "int");

            $paginator = new \Chen\Library\Paginator(
                array(
                    'dataFrom' => 'Chen\Models\Posts',
                    'limit'    => 2,
                    'page'     => $currentPage,
                )
            );
            
            //  获取结果
            $postsLists = $paginator->getPaginate();

            $this->view->posts_list = $postsLists;

        } else {
            return $this->response->redirect('cats/index');
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    //添加文章
    public function createAction($postid)
    {
        /*
        *   添加和更新文章
        *   2015-2-14
        */
        
        if (!empty($postid)) {
            //  检查数据库中是否存在将被更新的记录
            $post_update_find = Posts::findFirst($postid);
            //  如果存在，就设置输入框默认值
            if ($post_update_find != false) 
            {

                $this->tag->setDefault("post-id", $post_update_find->id);
                $this->tag->setDefault("post-title", $post_update_find->post_title);
                $this->tag->setDefault("post-content", $post_update_find->post_content);
                $this->tag->setDefault("post-keywords", $post_update_find->post_keywords);
                $this->tag->setDefault("post-description", $post_update_find->post_description);
                $this->view->post_type_value = $post_update_find->Types->id;
                $this->view->post_update_find = $post_update_find;

                $post_cats = array();                
                foreach ($post_update_find->PostsCategorys as $post_cat_value) 
                {
                    $post_cats[] = $post_cat_value->categorys_id;
                }
                $this->view->post_cat_value = $post_cats;

                $post_tags = array();
                foreach ($post_update_find->PostsTags as $post_tag_value) 
                {
                    $post_tags[] = $post_tag_value->Tags->tagtitle;
                }
                $post_tags = implode(",", $post_tags);
                $this->tag->setDefault("post-tag", $post_tags);

                $this->tag->setDefault("post-picture", $post_update_find->post_picture);
                $this->view->post_picture_id = $post_update_find->post_picture;

            } else {
                return $this->response->redirect('posts/index');
            }
        
        }

        //  读取类型
        $this->view->post_type_list = Types::find();
        //  读取分类
        $this->view->post_cat_list = Categorys::find();
        //  读取标签
        $this->view->post_tag_list = Tags::find();

        $this->tag->prependTitle('添加文章');
    }

    public function addAction()
    {

        if ($this->request->isPost() == true && $this->request->isAjax()) {
            
            //  获取文章ID
            $post_id = $this->request->getPost('post-id');
            
            
            //  获取文章标题
            $post_title = $this->request->getPost("post-title", "trim");
            //  检查是否输入标题
            if (empty($post_title)) {
                //$this->flashSession->error("请输入标题!");
                echo 'noPostTitle';
                exit;
            }


            //  获取文章内容
            $post_content = $this->request->getPost('post-content');        
            //  检查是否输入内容
            if (empty($post_content)) {
                //$this->flashSession->error("请输入内容!");
                echo 'noPostContent';
                exit;
            }
            //  替换内容
            $post_content = $this->img_info($post_content);
            $post_content = $this->removeHtml($post_content);


            //  获取关键词
            $post_keywords = $this->request->getPost('post-keywords');
            $post_keywords = trim($post_keywords);

            
            //  获取描述
            $post_description = $this->request->getPost('post-description');
            $post_description = trim($post_description);

            //  获取摘要
            $post_excerpt = $this->request->getPost('post-excerpt');
            $post_excerpt = trim($post_excerpt);
            
            //  获取类型
            $post_type = $this->request->getPost('post-type');
            //  检查是否选择类型
            if (empty($post_type)) {
                //$this->flashSession->error("没有选择类型!");
                echo 'noPostType';
                exit;
            }

            
            //  获取分类
            $post_cat = $this->request->getPost('post-cat');
            //  检查是否选择分类
            if (empty($post_cat)) {
                //$this->flashSession->error("没有选择分类!");
                echo 'noPostCat';
                exit;
            }

            
            //  获取标签
            $post_tag = $this->request->getPost('post-tag');
            //  检查是否输入标签
            if (empty($post_tag)) {
                //$this->flashSession->error("没有输入标签!");
                echo 'noPostTag';
                exit;
            }

            //  缩略图
            $post_picture = $this->request->getPost('post-picture','int');


            //  作者
            if ($this->session->has("user")) {
                //获取session中的user
                $user = $this->session->get("user");          
                //获取用户名id
                $post_author = $user["id"];                
            }

            $this->view->post_type_value = $post_type; 
            $this->view->post_cat_value = $post_cat;

            if (!empty($post_title) && !empty($post_content) && !empty($post_type) && !empty($post_cat) && !empty($post_tag)) {
                //  将标签(字符串)转换为数组
                $post_tag = explode("," ,$post_tag);
                
                if (empty($post_id)) {
                    
                    $this->db->begin();

                    $post = new Posts();

                    $post->post_title = $post_title;
                    $post->post_content = $post_content;
                    $post->post_excerpt = $post_excerpt;
                    $post->post_type = $post_type;
                    $post->post_author = $post_author;
                    $post->post_keywords = $post_keywords;
                    $post->post_description = $post_description;
                    //  缩略图
                    if (!empty($post_picture)) {
                        $post->post_picture = $post_picture;
                        //$this->view->post_picture_id = $post_picture;
                    }

                    if ($post->save() == false) {
                        //$this->flashSession->error("添加失败！");
                        echo 'errorPublish';
                        exit;
                        
                    } else {
                        //$this->flashSession->success("添加成功！");

                        $post_id = $post->id;
                        //$this->tag->setDefault("post-id", $post->id);
                        echo $post->id;

                        //  添加分类
                        $this->create_post_cat($post_id, $post_cat);
                        //  添加标签
                        $this->create_post_tag($post_id, $post_tag);

                    }

                    $this->db->commit();

                } else {
                    
                    $this->db->begin();

                    $post = new Posts();

                    $post->id = $post_id;
                    $post->post_title = $post_title;
                    $post->post_content = $post_content;
                    $post->post_excerpt = $post_excerpt;
                    $post->post_type = $post_type;
                    $post->post_author = $post_author;
                    $post->post_keywords = $post_keywords;
                    $post->post_description = $post_description;
                    //  缩略图
                    if (!empty($post_picture)) {
                        $post->post_picture = $post_picture;
                        //$this->view->post_picture_id = $post_picture;
                    }

                    if ($post->save() == false) {
                        //$this->flashSession->error("更新失败！");
                        echo 'errorUpdata';
                        exit;
                    } else {
                        //$this->flashSession->success("更新成功！");
                        echo 'successUpdate';

                        /*
                        *   更新分类
                        *   2015-2-14
                        */

                        //  根据文章 ID 查找分类 ID
                        $post_cat_find = PostsCategorys::find(array("posts_id = '$post_id'"));
                        //  将查找结果拼接成数组
                        $post_cat_id_update = array();
                        foreach ($post_cat_find as $post_cat_find_valve) {
                            $post_cat_id_update[] = $post_cat_find_valve->categorys_id;
                        }

                        //  比较表单提交数据和数据库中记录的差异来判断是否要更新
                        $post_cat_update = array_diff($post_cat, $post_cat_id_update);
                        $post_cat_delete = array_diff($post_cat_id_update, $post_cat);
                        
                        if (!empty($post_cat_update) || !empty($post_cat_delete)) {
                            //  根据 post_id 删除文章对应的所有分类
                            if ($post_cat_find->delete() == false) {
                                $this->flashSession->error("分类删除失败！");
                            } else {
                                //$this->flashSession->success("分类删除成功！");
                                //  重新添加分类
                                $this->create_post_cat($post_id, $post_cat);
                            }

                        }

                        /*
                        *   更新标签
                        *
                        */

                        //  根据 post_id 查找标签名称，并拼接成数组
                        $post_tag_find = PostsTags::find(array("posts_id = '$post_id'"));
                        $post_tagtitle = array();       
                        foreach ($post_tag_find as $tag_value) {
                            $post_tagtitle[] = $tag_value->Tags->tagtitle;
                        }

                        //  比较表单提交标签和数据库中标签是否相同
                        $post_tag_update = array_diff($post_tag, $post_tagtitle);
                        $post_tag_delete = array_diff($post_tagtitle, $post_tag);
                        if (!empty($post_tag_update) || !empty($post_tag_delete)) {
                            //  根据 post_id 删除文章对应的所有标签
                            if ($post_tag_find->delete() == false) {
                                $this->flashSession->error("标签删除失败！");
                            } else {
                                //$this->flashSession->success("标签删除成功！");
                                //  添加标签
                                $this->create_post_tag($post_id, $post_tag);
                            }

                        }

                    }               
                    
                    $this->db->commit();

                }               

            }

        } else {
            return $this->response->redirect('posts/index');
        }

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

    public function deleteAction()
    {
        if ($this->request->isPost() == true && $this->request->isAjax()) {

            $postId = $this->request->getPost("postId", "int");
            
            $postFind = Posts::findFirst($postId);
            if ($postFind != false) {
                
                if ($postFind->delete() == false) {

                    echo 'errorDelete';
                } else {

                    $postCatFind = PostsCategorys::find(array("posts_id = '$postId'"));
                    if ($postCatFind != false) 
                    {
                        $postCatFind->delete();
                    }

                    $postTagFind = PostsTags::find(array("posts_id = '$postId'"));
                    if ($postTagFind != false) 
                    {
                        $postTagFind->delete();
                    }
                    
                    echo 'successDelete';
                }
            } else {
                echo 'errorNoPost';
            }

        } else {
            return $this->response->redirect('posts/index');
        }

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        
    }

    
    /*
    *   图片信息替换
    *   2015-2-7
    */
    // protected function weilove_img_info ($img_info) { 
    //     $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
    //     $replacement = '<img$1src=$2$3.$4$5 alt="123" title="456"$6>';
    //     $img_info = preg_replace($pattern, $replacement, $img_info);
    //     return $img_info; 
    // }
    protected function img_info($post_content) 
    { 
        $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\") data-image-size=\"(.*?),(.*?)\"(.*?)>/i";
        $replacement = '<img src=$2$3.$4$5 width="$6" height="$7"$8>';
        $img_info = preg_replace($pattern, $replacement, $post_content);
        return $img_info; 
    }

    protected function removeHtml($post_content)
    {
        $pattern = '/(<p><br><\/p>)|(<br>)/i';
        $post_content = preg_replace($pattern, '', $post_content);
        return $post_content;
    }

    /*
    *   添加分类
    *   2015-2-14
    */

    protected function create_post_cat($post_id, $post_cat) 
    {
        foreach ($post_cat as $post_cat_id) 
        {
            $post_categorys = new PostsCategorys();
            $post_categorys->posts_id = $post_id;
            $post_categorys->categorys_id = $post_cat_id;
            
            if ($post_categorys->save() == false) 
            {                            
                //$this->flashSession->error("分类添加失败！");                           
            }
        }
    }


    /*
    *   添加标签
    *   2015-2-14
    */

    protected function create_post_tag($post_id, $post_tag) 
    {
        foreach ($post_tag as $post_tag_title) 
        {
            $post_tag_find = Tags::findFirst(array("tagtitle = '$post_tag_title'"));

            if ($post_tag_find != false) 
            {
                //$this->flashSession->success("标签查找成功！");

                $post_tags = new PostsTags();
                $post_tags->posts_id = $post_id;
                $post_tags->tags_id = $post_tag_find->id;
                if ($post_tags->save() == false) 
                {
                   //$this->flashSession->error("文章-标签添加失败！"); 
                }
            } 
            else 
            {
                //$this->flashSession->error("标签查找失败！");

                $tag_add = new Tags();
                $tag_add->tagtitle = $post_tag_title;                       
                $tag_add->anothername = $post_tag_title;
                $tag_add->description = $post_tag_title;

                if ($tag_add->save() == false) 
                {
                    //$this->flashSession->error("标签添加失败！"); 
                } 
                else 
                {
                    $post_tags = new PostsTags();
                    $post_tags->posts_id = $post_id;
                    $post_tags->tags_id = $tag_add->id;
                    if ($post_tags->save() == false) 
                    {
                        //$this->flashSession->error("文章-标签添加失败！"); 
                    }
                }
            }
        }
    }

}