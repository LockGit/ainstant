<?php
namespace Chen\Manage\Library;
use \Phalcon\Mvc\User\Component;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */

 class Elements extends Component
{
    private $_sidebarMenu = array(
        'home' => array(
            'caption' => ' 首页',
            'icon' => 'am-icon-home',
            'controller' => 'index',
            'action' => 'index'
            ),
        'post' => array(
            'caption' => ' 文章',
            'icon' => 'am-icon-file-text',
            'index' => array(
                'controller' => 'posts',
                'action' => 'index',
                'caption' => ' 所有文章',
                'icon' => 'am-icon-th-list'
                ),
            'add' => array(
                'controller' => 'posts',
                'action' => 'create',
                'caption' => ' 添加文章',
                'icon' => 'am-icon-pencil'
                ),
            'category' => array(
                'controller' => 'cats',
                'action' => 'index',
                'caption' => ' 分类',
                'icon' => 'am-icon-th'
                ),
            'tag' => array(
                'controller' => 'tags',
                'action' => 'index',
                'caption' => ' 标签',
                'icon' => 'am-icon-tags'
                ),
            'type' => array(
                'controller' => 'types',
                'action' => 'index',
                'caption' => ' 类型',
                'icon' => 'am-icon-cube'
                )
            ),
        'media' => array(
            'caption' => ' 媒体',
            'icon' => 'am-icon-picture-o',
            'medialibrary'=> array(
                'controller' => 'medialibrary',
                'action' => 'index',
                'caption' => ' 媒体库',
                'icon' => 'am-icon-inbox'
                ),
            'add' => array(
                'controller' => 'medialibrary',
                'action' => 'add',
                'caption' => ' 添加',
                'icon' => 'am-icon-upload'
                ) 
            ),
        'option' => array(
            'caption' => ' 设置',
            'icon' => 'am-icon-cogs',
            'option' => array(
                'controller' => 'option',
                'action' => 'index',
                'caption' => ' 常规',
                'icon' => 'am-icon-road'
                ),
            'userlist' => array(
                'controller' => 'option',
                'action' => 'read',
                'caption' => ' 阅读',
                'icon' => 'am-icon-book'
                )
            ),
        'session' => array(
            'caption' => ' 注销',
            'icon' => 'am-icon-sign-out',
            'controller' => 'session',
            'action' => 'logout'
            )
    );
    

    /**
     * 构建侧边栏菜单
     *
     * @return 字符串(string)
     */
    
    public function getSidebarMenu(){
        //  获取当前控制器名称
        $controllerName = $this->view->getControllerName();
        //  获取当前action名称
        $actionName = $this->view->getActionName();
        //  定义初始值
        $countSub = 1;

        //构造函数，判断子数组中是否存在当前控制器名和action名，
        function is_SidebarActive($menu,$controllerName){
            foreach ($menu as $option) {     
                if (is_array($option)){
                    /*
                    if ($controllerName == $option['controller']) {
                       return true;
                    } else {
                        return false;
                    };
                    */
                    if ($controllerName == $option['controller']) {
                        return true;
                    } elseif ( ($controllerName == 'cats' && $option['controller'] == 'posts') || ($controllerName == 'tags' && $option['controller'] == 'posts') || ($controllerName == 'types' && $option['controller'] == 'posts')) {
                        return true;
                    } else {
                        return false;
                    }
                };               
            };
        }

        echo '<ul class="am-list admin-sidebar-list">';

        foreach ($this->_sidebarMenu as $menu) {
            if ( isset($menu['controller']) || array_key_exists('controller',$menu) ) {
                //echo '<li><a href="admin-index.html"><span class="am-icon-home"></span> 首页</a></li>';
                echo '<li>'.$this->tag->linkTo($menu['controller'] . '/' . $menu['action'], '<span class="'.$menu['icon'].'"></span>'.$menu['caption']).'</li>';
            } else {
                //echo $countSub;
                echo '<li class="admin-parent">';
                echo '<a class="am-cf" data-am-collapse="{target: \'#collapse-nav'.$countSub.'\'}"><span class="'.$menu['icon'].'"></span>'.$menu['caption'].'<span class="am-icon-angle-right am-fr am-margin-right"></span></a>';    
                
                //根据函数返回结果，输出class
                if (is_SidebarActive($menu,$controllerName) == true){
                    echo '<ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav'.$countSub.'">';
                } else {
                    echo '<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav'.$countSub.'">'; 
                };

                //echo '<ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav'.$countSub.'">';
                    
                    foreach ($menu as $menuSon) {
                        if (is_array($menuSon)){
                            //echo '<li><a href="admin-user.html" class="am-cf"><span class="am-icon-th-list"></span> 文章列表</a></li>';
                            //echo '<li>'.$this->tag->linkTo($menu['controller'] . '/' . $menu['action'], '<span class="'.$menu['icon'].'"></span>'.$menu['caption'], "class" => "am-form").'</li>';
                            //echo $this->tag->linkTo('index/index',"class" => "am-form");
                            echo '<li>'.$this->tag->linkTo(array($menuSon['controller'] . '/' . $menuSon['action'], '<span class="'.$menuSon['icon'].'"></span>'.$menuSon['caption'], 'class' => 'am-form')).'</li>';
                        }
                    }

                echo '</ul></li>';
                $countSub++;
            }
        }

        echo '</ul>';
    }
    
}