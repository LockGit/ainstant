<?php
namespace Chen\Frontend\Library;
use \Phalcon\Mvc\User\Component;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */

 class Elements extends Component
{
    
    
    public function getNav($page){
        
        $current = $page->current;
        $before = $page->before;
        $next = $page->next;
        $last = $page->last;
        $total_pages = $page->total_pages;
        $total_items = $page->total_items;

        echo '<div class="pagenavi">';
            
            echo '<a href="?page=1">首页</a>';
            echo '<a href="?page='.$before.'">上一页</a>';
            //echo '<a href="">'.$current.'</a>';
            echo '<span class="current-nav">'.$current.'</span>';
            echo '<a href="?page='.$next.'">下一页</a>';
            echo '<a href="?page='.$last.'">末页</a>';
            echo '<a href="#">共 '.$total_pages.' 页</a>';

        echo '</div>';
    }
    
}