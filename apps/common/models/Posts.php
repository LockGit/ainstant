<?php
namespace Chen\Models;

use \Phalcon\Tag;
use \Phalcon\Mvc\Model\Query;
//use Chen\Plugins\ChenHookPlugin;

class Posts extends \Phalcon\Mvc\Model
{
	/**
     * @var integer
     *      id
     */
    public $id;

     /**
     * @var string
     *		标题
     */
    public $post_title;

     /**
     * @var longtext
     *		内容
     */
    public $post_content;

    /**
     * @var datetime
     *		发布时间
     */
    public $publish_time;

    /**
     * @var update_time
     *      更新时间
     */
    public $update_time;

    /**
     * @var text
     *      摘要
     */
    public $post_excerpt;

    /**
     * @var int
     *      类型
     */
    public $post_type;

     /**
     * @var int
     *		作者
     */
    public $post_author;

    /**
     * @var string
     *      关键词
     */
    public $post_keywords;

    /**
     * @var string
     *      描述
     */
    public $post_description;

    /**
     * @var string
     *      略缩图
     */
    public $post_picture;


    public function beforeCreate()
    {
        $this->publish_time = time();
    }

    public function beforeUpdate()
    {
        $this->update_time = time();
    }

    public function initialize()
    {
        $this->hasMany('id', 'Chen\Models\PostsCategorys', 'posts_id',array(
            'alias' => 'postscategorys'
        ));
        $this->hasMany('id', 'Chen\Models\PostsTags', 'posts_id',array(
            'alias' => 'poststags'
        ));
        $this->belongsTo('post_type', 'Chen\Models\Types', 'id',array(
            'alias' => 'types'
        ));
        $this->hasOne('post_picture', 'Chen\Models\Files', 'id',array(
            'alias' => 'files'
        ));
        $this->hasOne('id', 'Chen\Models\PostsViews', 'post_id',array(
            'alias' => 'postsviews'
        ));
        $this->hasOne('post_author', 'Chen\Models\Users', 'id',array(
            'alias' => 'users'
        ));
        //  动态更新
        $this->useDynamicUpdate(true);
        //Skips fields/columns on both INSERT/UPDATE operations
        //$this->skipAttributes(array('post_viewcount'));
        //Skips only when inserting
        $this->skipAttributesOnCreate(array('update_time'));

        //Skips only when updating
        $this->skipAttributesOnUpdate(array('publish_time'));
    }

    public function getPostUrl() 
    { 
        return $postUrl = APP_URL.'/'.$this->id.'.html';
    } 

    public function getPublishedDate()
    {
        return date('Y-m-d H:i:s', $this->publish_time);
    }

    public function getFeedPublishedDate()
    {
        return date('D, d M Y H:i:s +0000', $this->publish_time);
    }

    public function getFeedLastBuildDate()
    {
        $lastBuildDate = self::findFirst(array('columns' => 'publish_time'))->publish_time;
        return date('D, d M Y H:i:s +0000', $lastBuildDate);
    }

    public function getPostTitle($max_length = 30) 
    { 
        
        $title_str = $this->post_title; 

        if (mb_strlen($title_str,'utf-8') > $max_length ) { 
            $title_str = mb_substr($title_str,0,$max_length,'utf-8').'...';
        } 
        return $title_str; 
    } 

    public function getAuthor()
    {
        $author = $this->getUsers(array('columns' => 'username, nicename'));
        if (!empty($author->nicename)) {
            return $author->nicename;
        } else {
            return $author->username;
        }
        
    }
    
    public function getPostExcerpt($max_length = 100) 
    { 
        if (empty($this->post_excerpt)) {
            $excerpt_str = $this->post_content;
        } else {
            $excerpt_str = $this->post_excerpt;
        }

        return $this->chen_trim_words($excerpt_str,$max_length); 
    }
    
    public function getPostType() 
    {
        return $this->getTypes(array('columns' => 'typetitle'))->typetitle;
    }
    
    public function getPostCategory($glue = ',')
    {
        
        $phql = 'SELECT Chen\Models\Categorys.cattitle FROM Chen\Models\PostsCategorys INNER JOIN Chen\Models\Categorys WHERE posts_id ='.$this->id;
        $query = $this->modelsManager->executeQuery($phql);

        $categorys = array();
        foreach ($query as $value) {
            $categorys[] = $value->cattitle;
        }

        return implode(' '.$glue.' ', $categorys);
    }
    
    public function getPostCategoryLink($glue = ',')
    {

        $phql = 'SELECT Chen\Models\Categorys.cattitle FROM Chen\Models\PostsCategorys INNER JOIN Chen\Models\Categorys WHERE posts_id ='.$this->id;
        $query = $this->modelsManager->executeQuery($phql);

        $categorys = array();
        foreach ($query as $value) {
            $categoryName = $value->cattitle;
            $categoryUrl = urlencode($categoryName);
            $categorys[] = Tag::linkTo(array('category/'.$categoryUrl, $categoryName));
        }
        return implode(' '.$glue.' ', $categorys);
    }
    
    public function getArrayPostCategory()
    {
        $phql = 'SELECT Chen\Models\Categorys.cattitle FROM Chen\Models\PostsCategorys INNER JOIN Chen\Models\Categorys WHERE posts_id ='.$this->id;
        $query = $this->modelsManager->executeQuery($phql);

        $categorys = array();
        foreach ($query as $value) {
            $categorys[] = $value->cattitle;
        }

        return $categorys;
    }

    public function getPostTag($glue = ',') 
    {

        $phql = 'SELECT Chen\Models\Tags.tagtitle FROM Chen\Models\PostsTags INNER JOIN Chen\Models\Tags WHERE posts_id ='.$this->id;
        $query = $this->modelsManager->executeQuery($phql);

        $tags = array();
        foreach ($query as $value) {
            $tags[] = $value->tagtitle;
        }

        return implode(' '.$glue.' ', $tags);
    }
    
    public function getPostTagLink($glue = ',') 
    {

        $phql = 'SELECT Chen\Models\Tags.tagtitle FROM Chen\Models\PostsTags INNER JOIN Chen\Models\Tags WHERE posts_id ='.$this->id;
        $query = $this->modelsManager->executeQuery($phql);

        $tags = array();
        foreach ($query as $value) {
            $tagName = $value->tagtitle;
            $tagUrl = urlencode($tagName);
            $tags[] = Tag::linkTo(array('tag/'.$tagUrl, $tagName));
        }

        return implode(' '.$glue.' ', $tags);
    }
    
    public function getPostView() 
    {                       
        
        $postViewCount = $this->getPostsViews(array('columns' => 'post_view'));

        if ($postViewCount != false) {
            $count = $postViewCount->post_view;
        } else {
            $postView = new PostsViews();
            $postView->post_id = $this->id;
            if($postView->save() != false){
                $count = $postView->post_view;
            }
        }

        if (empty($count)) {
            return 0;
        } else {
            return $count;
        }

    }

    public function setPostView()
    {        
        $postViewCount = $this->getPostsViews();

        if ($postViewCount != false) {
            $postView = new PostsViews();
            $postView->id = $postViewCount->id;
            $postView->post_view = $postViewCount->post_view + 1;
            $postView->save();
        } else {
            $postView = new PostsViews();
            $postView->post_id = $this->id;
            $postView->save();
        }
        
    }

    public function getContent()
    {
        $content = $this->post_content;
        $title = $this->post_title;
        
        // $contenthook = ChenHookPlugin::do_action('the_content', array($content));

        // if (!empty($contenthook)) {
        //     $content = $contenthook;
        // }


        $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
        $replacement = '<img src=$2'.APP_IMAGE_URL.'$3.$4$5 title="'.$title.'" alt="'.$title.'"$6>';
        $content = preg_replace($pattern, $replacement, $content);

        return $content;
    }

    public function getPostThumbnail($width = 80, $height = 60)
    {
        if (!empty($this->post_picture)) {
            $imageUrl = APP_IMAGE_URL.$this->files->getThumbnail($width, $height);
        } else {

            $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $this->post_content, $matches);  //正则匹配文章中所有图片
            $first_img = $matches[1][0];

            if(empty($first_img)){ 
                
                $defaultImages = array('1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg');
                $n = rand(0,count($defaultImages)-1);    
                $randImage = $defaultImages[$n];
                $image = APP_IMAGE_URL.'/upload/images/default/'.$randImage;
                
                return '<img src="'.$image.'" alt="'.$this->post_title.'" width="500" height="340" />';
            } else {
                $imageUrl = APP_IMAGE_URL.$first_img;
            }            
        }

        if (!empty($imageUrl)) {
            return $imageLink = '<img src="'.$imageUrl.'" alt="'.$this->post_title.'" width="'.$width.'" height="'.$height.'" />';
        }

    }

    public function getNextPost()
    {
        $maxId = self::maximum(array('column' => 'id'));     
        $id = $this->id;
        if ( $maxId == $id ) {
            $nextPost = '';
        } else {
            do {           
                $id ++;
                $nextPost = self::findFirst($id);
            } while ( $nextPost == false );
        }

        if (empty($nextPost)) {
            return '<a href="javascript:alert(\'木有啦，已经是最后一篇了...\');">木有啦</a>';
        } else {
            return '<a href="'.$nextPost->getPostUrl().'">'.$nextPost->getPostTitle().'</a>';
        }
    }

    public function getNextPostButton()
    {
        $maxId = self::maximum(array('column' => 'id'));     
        $id = $this->id;
        if ( $maxId == $id ) {
            $nextPost = '';
        } else {
            do {           
                $id ++;
                $nextPost = self::findFirst($id);
            } while ( $nextPost == false );
        }

        if (empty($nextPost)) {
            return '<a href="javascript:alert(\'木有啦，已经是最后一篇了...\');">木有啦</a>';
        } else {
            return '<a href="'.$nextPost->getPostUrl().'">下一篇</a>';
        }
    }

    public function getPreviousPost()
    {
        $minId = self::minimum(array('column' => 'id'));       
        $id = $this->id;
        if ( $minId == $id ) {
            $prevPost = '';
        } else {
            do {           
                $id --;
                $prevPost = self::findFirst($id);                
            } while ( $prevPost == false );
        }
        
        if (empty($prevPost)) {
            return '<a href="javascript:alert(\'木有啦，已经是第一篇了...\');">木有啦</a>';
        } else {
            return '<a href="'.$prevPost->getPostUrl().'">'.$prevPost->getPostTitle().'</a>';
        }
    }

    public function getPreviousPostButton()
    {
        $minId = self::minimum(array('column' => 'id'));       
        $id = $this->id;
        if ( $minId == $id ) {
            $prevPost = '';
        } else {
            do {           
                $id --;
                $prevPost = self::findFirst($id);                
            } while ( $prevPost == false );
        }
        
        if (empty($prevPost)) {
            return '<a href="javascript:alert(\'木有啦，已经是第一篇了...\');">木有啦</a>';
        } else {
            return '<a href="'.$prevPost->getPostUrl().'">上一篇</a>';
        }
    }

    public function getRelatedPost($number = 10)
    {

        $phql = 'SELECT Chen\Models\Tags.id FROM Chen\Models\PostsTags INNER JOIN Chen\Models\Tags WHERE posts_id ='.$this->id;
        $queryTag = $this->modelsManager->executeQuery($phql);

        $tagId = array();
        foreach ($queryTag as $value) {
            $tagId[] = $value->id;
        }

        $phql2 = 'SELECT Chen\Models\Posts.id FROM Chen\Models\PostsTags INNER JOIN Chen\Models\Posts WHERE tags_id IN ('.implode(',', $tagId).')';
        $queryPost = $this->modelsManager->executeQuery($phql2);

        $postId = array();
        foreach ($queryPost as $value) {
            $postId[] = $value->id;
        }

        $postId  = array_unique($postId);
        $postIdCount = count($postId);
        
        if ($postIdCount < $number) {

            $phql3 = 'SELECT Chen\Models\Categorys.id FROM Chen\Models\PostsCategorys INNER JOIN Chen\Models\Categorys WHERE posts_id ='.$this->id;
            $queryCat = $this->modelsManager->executeQuery($phql3);

            $catId = array();
            foreach ($queryCat as $value) {
                $catId[] = $value->id;
            }

            $phql4 = 'SELECT Chen\Models\Posts.id FROM Chen\Models\PostsCategorys INNER JOIN Chen\Models\Posts WHERE categorys_id IN ('.implode(',', $catId).')';
            $queryPost2 = $this->modelsManager->executeQuery($phql4);

            $postId2 = array();
            foreach ($queryPost2 as $value) {
                $postId2[] = $value->id;
            }
            
            $postId2  = array_unique($postId2);
            $postId2 = array_diff($postId2, $postId);
            $postId2Count = count($postId2);

            $reduce = $number - $postIdCount;
            if ( $postId2Count > $reduce) {
                
                $postId3 = array();
                $postIdKeys = array_rand($postId2, $reduce);
                if (is_array($postIdKeys)) {
                    foreach ($postIdKeys as $key) {
                        $postId3[] = $postId2[$key];
                    }
                } else {
                    $postId3[] = $postId2[$postIdKeys];
                }

                $postId2 = $postId3;
            
            }

            $postIds = array_merge($postId, $postId2);

        } elseif ($postIdCount > $number) {
            
            $postIds = array();
            $postIdKeys = array_rand($postId, $number);
            foreach ($postIdKeys as $key) {
                $postIds[] = $postId[$key];
            }

        } else {
            $postIds = $postId;
        }

        $phql = 'SELECT * FROM Chen\Models\Posts WHERE id IN ('.implode(',', $postIds).')';
        return  $this->modelsManager->executeQuery($phql);

    }

    public function getNewPost($number = 10)
    {
        return self::find(array("order" => "id DESC", "limit" => $number));
    }

    public function getRandPost($number = 10)
    {
        $postId = array();
        $posts = self::find(array('columns' => 'id'));
        //$query = new Query("SELECT id FROM Chen\Models\Posts", $this->getDI());
        //$posts = $query->execute();

        foreach ($posts as $post) {
            $postId[] = $post->id;
        }

        $postIdCount = count($postId);
        if ($postIdCount > $number) {
            $postIdKey = array_rand($postId, $number);
            $postIdRand = array();
            foreach ($postIdKey as $key) {
                $postIdRand[] = $postId[$key];
            }
        } else {
            $postIdRand = $postId;
        }

        $phql = 'SELECT * FROM Chen\Models\Posts WHERE id IN ('.implode(',', $postIdRand).')';
        return $this->modelsManager->executeQuery($phql);
    }

    public function getAbc()
    {
        
        
        //$phql = 'SELECT Chen\Models\Categorys.* FROM Chen\Models\PostsCategorys INNER JOIN Chen\Models\Categorys WHERE posts_id ='.$this->id;
        //$query = $this->modelsManager->executeQuery($phql);
        
        //$categorys = array();
        //foreach ($query as $value) {
        //    $categorys[] = $value->cattitle;
        //}

        //return $categorys;
        //return $query->toArray();
        //return $query;
        $limit = 2;
        $start = 3;
        $categorys_id = 1;
        //$phql = 'SELECT Chen\Models\Posts.id FROM Chen\Models\PostsCategorys INNER JOIN Chen\Models\Posts WHERE categorys_id = 1 ORDER BY Chen\Models\Posts.id DESC LIMIT '.$limit.' OFFSET '.$start;
        $phql = 'SELECT COUNT(Chen\Models\PostsCategorys.posts_id) AS post_count FROM Chen\Models\PostsCategorys WHERE categorys_id = '.$categorys_id;
        $query = $this->modelsManager->executeQuery($phql);
        
        //foreach ($query as $row) {
        //    $post_count = $row->post_count;
        //}

        return $query;
    }

    public function getPostCount()
    {
        return self::count();
    }

    protected function chen_trim_words( $text, $num_words = 55, $more = null ) {
        if ( null === $more )
            $more = '&hellip;';
        $original_text = $text;
        $text = $this->chen_strip_all_tags( $text );
        
        if ( preg_match( '/^utf\-?8$/i', 'utf-8' ) ) {
            $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
            preg_match_all( '/./u', $text, $words_array );
            $words_array = array_slice( $words_array[0], 0, $num_words + 1 );
            $sep = '';
        } else {
            $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
            $sep = ' ';
        }
        if ( count( $words_array ) > $num_words ) {
            array_pop( $words_array );
            $text = implode( $sep, $words_array );
            $text = $text . $more;
        } else {
            $text = implode( $sep, $words_array );
        }
        
        return $text;
    }

    protected function chen_strip_all_tags($string, $remove_breaks = false) {
        $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
        $string = strip_tags($string);

        if ( $remove_breaks )
            $string = preg_replace('/[\r\n\t ]+/', ' ', $string);

        return trim( $string );
    }

}