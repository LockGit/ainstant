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
    
    /* web */
    public function getBreadCrumb($crumbName = null)
    {

        $controllerName = $this->view->getControllerName();
        //$actionName = $this->view->getActionName();
        
        echo '<div id="crumbs">你在这里 : ';
        if ($controllerName == 'index') {
            echo '<a href="'.APP_URL.'">首页</a>';
        }
        if ($controllerName == 'category') {
            echo '<a href="'.APP_URL.'">首页</a> -> 分类 -> '.$crumbName;
        }
        if ($controllerName == 'tag') {
            echo '<a href="'.APP_URL.'">首页</a> -> 标签 -> '.$crumbName;
        }
        if ($controllerName == 'post') {
            echo '<a href="'.APP_URL.'">首页</a> -> 阅读 -> '.$crumbName;
        }

        echo '</div>';
        
    }
    
    public function getTopNav($page)
    {

        $current = $page->current;
        $before = $page->before;
        $next = $page->next;
        $last = $page->last;

        echo '<div class="prev-next">';
            if ($current != $before) {
                echo '<a class="prev" href="?page='.$before.'">上一页</a>';
            }
            echo '<span class="prev-next-page">第'.$current.'页</span>';
            if ($current != $next) {    
                echo '<a class="" href="?page='.$next.'">下一页</a>';
            }
        echo '</div>';
    }
    
    public function getNav($page)
    {
        
        $current = $page->current;
        $before = $page->before;
        $next = $page->next;
        $last = $page->last;
        $total_pages = $page->total_pages;
        $total_items = $page->total_items;

        echo '<div class="pagenavi">';
            if ($current != 1) {
                echo '<a href="?page=1">首页</a>';
            }
            if ($current != $before) {
                echo '<a href="?page='.$before.'">上一页</a>';
            }            
            echo '<span class="current-nav">'.$current.'</span>';
            if ($current != $next) {
                echo '<a href="?page='.$next.'">下一页</a>';
            }
            if ($current != $last) {
                echo '<a href="?page='.$last.'">末页</a>';
            }
            echo '<a href="#">共 '.$total_pages.' 页</a>';
            echo '<a href="#">共 '.$total_items.' 篇文章</a>';

        echo '</div>';
    }

    /* web */

    /* wap */
    public function getNavMobile($page)
    {

        $current = $page->current;
        $before = $page->before;
        $next = $page->next;

        echo '<div class="prev-next">';
            if ($current != $before) {
                echo '<a class="prev" href="?page='.$before.'">上一页</a>';
            }
            echo '<span class="prev-next-page">第'.$current.'页</span>';
            if ($current != $next) {    
                echo '<a class="" href="?page='.$next.'">下一页</a>';
            }
        echo '</div>';
    }

    /* wap */
    
}