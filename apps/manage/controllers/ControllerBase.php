<?php

namespace Chen\Manage\Controllers;
use \Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{


    protected function initialize()
    {
        //判断用户是否登录，如果没有登录，返回登录页
        if (!$this->session->has("user")) 
        {
            return $this->response->redirect('session');
        }

        if ($this->session->has("user")) 
        {
            //获取session中的user
            $user = $this->session->get("user");          
            //获取用户名
            $username = $user["username"];
            //获取昵称
            $nicename = $user["nicename"];
            //如果用户昵称不为空，向视图传递昵称，否则传递用户名
            if (!empty($nicename)) 
            {
                $this->view->setVar("name", $nicename);
            } 
            elseif (!empty($username)) 
            {
                $this->view->setVar("name", $username);
            }
        }

        //设置标题分离器
        $this->tag->setTitleSeparator(' | ');
        //设置标题
        $this->tag->setTitle('一刻');
        //$this->tag->prependTitle('首页');

        $this->view->setTemplateAfter('main');
    }

    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1]
            )
        );
    }

}