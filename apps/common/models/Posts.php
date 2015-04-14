<?php
namespace Chen\Models;

use \Phalcon\Tag;
use \Phalcon\Mvc\Model\Query;
//use Chen\Plugins\ChenHookPlugin;

//文章
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
     *      浏览次数
     */
    public $post_viewcount;

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
        //return $this->id;
    } 

    public function getPublishedDate()
    {
        //return strftime('%Y %m %d %H %M %S', $this->publish_time);
        return date("Y-m-d H:i:s", $this->publish_time);
    }

    public function getPostTitle($max_length = 30) 
    { 
        
        $title_str = $this->post_title; 

        if (mb_strlen($title_str,'utf-8') > $max_length ) { 
            $title_str = mb_substr($title_str,0,$max_length,'utf-8').'...';
        } 
        return $title_str; 
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
        return $this->getTypes()->typetitle;
    }
    
    public function getPostCategory() 
    {
        $categorys = array();
        foreach ($this->getPostsCategorys() as $PostsCategory) {
            $category = $PostsCategory->getCategorys();
            $categorys[] = $category->cattitle;
        }
        return implode(' , ',$categorys);
    }
    
    public function getPostCategoryLink() 
    {
        $categorys = array();
        foreach ($this->getPostsCategorys() as $PostsCategory) {
            $category = $PostsCategory->getCategorys();
            $categorys[] = Tag::linkTo(array('category/'.$category->cattitle, $category->cattitle));
        }
        return implode(' , ',$categorys);
    }
    
    public function getPostTag() 
    {
        $tags = array();
        foreach ($this->getPostsTags() as $TagsCategory) {
            $tag = $TagsCategory->getTags();
            $tags[] = $tag->tagtitle;
        }
        return implode(' , ',$tags);
    }
    
    public function getPostTagLink() 
    {
        $tags = array();
        foreach ($this->getPostsTags() as $TagsCategory) {
            $tag = $TagsCategory->getTags();
            $tags[] = Tag::linkTo(array('tag/'.$tag->tagtitle, $tag->tagtitle));
        }
        return implode(' , ',$tags);
    }
    
    public function getPostView() 
    {       
                
        $viewcount = $this->post_viewcount;
        return $viewcount;
    }

    public function setPostView()
    {       
        $this->skipAttributes(array('update_time','publish_time'));        
        $viewcount = $this->post_viewcount;
        $this->post_viewcount = $viewcount + 1;
        $this->save();
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
        $replacement = '<img src=$2'.APP_URL.'$3.$4$5 title="'.$title.'" alt="'.$title.'"$6>';
        $content = preg_replace($pattern, $replacement, $content);

        return $content;
    }

    public function getPostThumbnail($width = 80, $height = 60)
    {
        if (!empty($this->post_picture)) {
            $imageUrl = APP_URL.$this->files->getThumbnail($width, $height);
        } else {

            $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $this->post_content, $matches);  //正则匹配文章中所有图片
            $first_img = $matches[1][0];

            if(empty($first_img)){ 
                
                $defaultImages = array('1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg');
                $n = rand(0,count($defaultImages)-1);    
                $randImage = $defaultImages[$n];
                $image = APP_URL.'/upload/images/default/'.$randImage;
                
                return '<img src="'.$image.'" alt="'.$this->post_title.'" width="500" height="340" />';
            } else {
                $imageUrl = APP_URL.$first_img;
            }            
        }

        if (!empty($imageUrl)) {
            return $imageLink = '<img src="'.$imageUrl.'" alt="'.$this->post_title.'" width="'.$width.'" height="'.$height.'" />';
        }

    }

    public function getNextPost()
    {
        $maxId = self::maximum(array("column" => "id"));     
        $id = $this->id;
        if ( $maxId == $id ) {
            $nextPost = '';
        } else {
            $id ++;
            do {           
                $nextPost = self::findFirst($id);
                $id ++;
            } while ( $nextPost == false );
        }
        return $nextPost;
    }

    public function getPreviousPost()
    {
        $minId = self::minimum(array("column" => "id"));       
        $id = $this->id;
        if ( $minId == $id ) {
            $prevPost = '';
        } else {
            $id --;
            do {           
                $prevPost = self::findFirst($id);
                $id --;
            } while ( $prevPost == false );
        }
        return $prevPost;
    }

    public function getRelatedPost($number = 10)
    {
        
        $postId = array();
        foreach ($this->getPostsTags() as $postsTags) {
            $tag = $postsTags->getTags();
            foreach ($tag->getPostsTags() as $postsTags) {
                $getPost = $postsTags->getPosts();
                if ($getPost != false) {
                    $postId[] = $getPost->id; 
                } 
            }            
        }

        $postId  = array_unique($postId);
        $postIdCount = count($postId);
        
        if ($postIdCount < $number) {

            $postId2 = array();
            foreach ($this->getPostsCategorys() as $PostsCategory) {
                $cat = $PostsCategory->getCategorys();
                foreach ($cat->getPostsCategorys() as $PostsCategory) {
                    $getPost = $PostsCategory->getPosts();
                    if ($getPost != false) {
                        $postId2[] = $getPost->id; 
                    } 
                }            
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

        $posts = array();
        foreach ($postIds as $value) {
            $posts[] = self::findFirst($value);
        }

        return  $posts;

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

        $posts = array();
        foreach ($postIdRand as $value) {
            $posts[] = self::findFirst($value);
        }

        return $posts;
    }

    public function getPhql()
    {   

        //$query = new Query("SELECT id FROM Chen\Models\Posts", $this->getDI());
        //$posts = $query->execute();

        //$postId = array();
        //foreach ($posts as $post) {
        //    $postId[] = $post->id;
        //}
        //$posts = self::findFirst(array('7', 'columns' => 'id'));
        //$posts = self::find();

        //return $posts;
        return $this->files->getThumbnail(200,150);
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
        
        if ( 'characters' == 'word count: words or characters?' && preg_match( '/^utf\-?8$/i', 'utf-8' ) ) {
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