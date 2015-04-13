<?php

namespace Chen\Manage\Controllers;
use Phalcon\Mvc\Controller;
use Chen\Models\Users;

class SessionController extends Controller
{

	public function initialize()
    {
        //设置标题分离器
        $this->tag->setTitleSeparator(' | ');
        //设置标题
        $this->tag->setTitle('一刻');
        //前置一个文本到当前文档标题
        //$this->tag->prependTitle('一刻');
        //添加一个文本到当前文档标题
        $this->tag->appendTitle('登陆');    

    }

    //登录页面
    public function indexAction()
    {

        if ($this->session->has("user")) {
            return $this->response->redirect();
        }

        $password = 'dangcheng';
        $password2 = $this->security->hash($password);
        $this->view->setVar("password", $password2);
    }

    public function loginAction()
    {
        if ($this->request->isPost() == true && $this->request->isAjax()) {
            //检查CSRF令牌是否有效,防止跨站点请求伪造攻击
            if ($this->security->checkToken()) {        

                $username = $this->request->getPost('username');

                if (empty($username)) {
                    echo 'noEmptyUsername';
                } else {

                    $password = $this->request->getPost('password');              
                    $users = Users::findFirstByUsername($username);
                    if ($users != false) 
                    {

                        if ($this->security->checkHash($password, $users->password)) 
                        {                                      
                            $this->_registerSession($users);
                            echo 'success';    
                        } else {
                            echo 'noPassword';
                        }
                    } else {
                        echo 'noUsername';
                    }
                }
                
            } else {
                echo 'NO';
            }
        }
        if ($this->request->isPost() == false) {
            
            if ($this->session->has("user")) {
                return $this->response->redirect();
            }
            else
            {
                return $this->response->redirect('session');
            }
        }
        
    }

    //注销
    public function logoutAction()
    {
        //清除session
        //$this->session->destroy();
        $this->session->remove("user");
        return $this->response->redirect('session');
    }

    //设置session
    private function _registerSession($users)
    {       
        $this->session->set('user', array(
            'id' => $users->id,
            'username' => $users->username,
            'nicename' => $users->nicename
        ));            
    }

}