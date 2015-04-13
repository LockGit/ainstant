<?php
namespace Chen\Plugins;

use \Phalcon\Mvc\User\Plugin;

/**
 * NotFoundPlugin
 *
 * Handles not-found controller/actions
 */
class ChenHookPlugin extends Plugin
{
    //action hooks array  
    private static $actions = array();
    /**
     * ads a function to an action hook
     * @param $hook
     * @param $function
     */
    public static function add_action($hook,$function)
    {   
        $hook=mb_strtolower($hook,CHARSET);
        // create an array of function handlers if it doesn't already exist
        if(!self::exists_action($hook))
        {
            self::$actions[$hook] = array();
        }
        // append the current function to the list of function handlers
        if (is_callable($function))
        {
            self::$actions[$hook][] = $function;
            return TRUE;
        }
        return FALSE;
    }
    /**
     * executes the functions for the given hook
     * @param string $hook
     * @param array $params
     * @return boolean true if a hook was setted
     */
    public static function do_action($hook,$params=NULL)
    {
        $hook=mb_strtolower($hook,CHARSET);
        if(isset(self::$actions[$hook]))
        {
            // call each function handler associated with this hook
            foreach(self::$actions[$hook] as $function)
            {
                if (is_array($params))
                {
                    $content = call_user_func_array($function,$params);
                    //call_user_func_array($function,$params);
                }
                else
                {
                    $content = call_user_func($function);
                    //call_user_func($function);
                }
                //cant return anything since we are in a loop! dude!
            }
            return $content;
            //return true;
        }
        return FALSE;
    }
    /**
     * gets the functions for the given hook
     * @param string $hook
     * @return mixed
     */
    public static function get_action($hook)
    {
        $hook=mb_strtolower($hook,CHARSET);
        return (isset(self::$actions[$hook]))? self::$actions[$hook]:FALSE;
    }
    /**
     * check exists the functions for the given hook
     * @param string $hook
     * @return boolean
     */
    public static function exists_action($hook)
    {
        $hook=mb_strtolower($hook,CHARSET);
        return (isset(self::$actions[$hook]))? TRUE:FALSE;
    }
}

    /**
     * Hooks Shortcuts not in class
     */
    /*
    function add_action($hook,$function)
    {
        return Hook::add_action($hook,$function);
    }
 
    function do_action($hook)
    {
        return Hook::do_action($hook);
    }
    */

//添加钩子
//Hook::add_action('unique_name_hook','some_class::hook_test');

//或使用快捷函数添加钩子:
//add_action('unique_name_hook','other_class::hello');
//add_action('unique_name_hook','some_public_function');

//执行钩子
//do_action('unique_name_hook');//也可以使用 Hook::do_action();