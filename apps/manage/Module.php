<?php
namespace Chen\Manage;

use Chen\Plugins\NotFoundPlugin;

class Module
{

	public function registerAutoloaders()
	{

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'Chen\Manage\Controllers' => '../apps/manage/controllers/',
			'Chen\Manage\Models' => '../apps/manage/models/',
			'Chen\Manage\Plugins' => '../apps/manage/plugins/',
			'Chen\Manage\Library' => '../apps/manage/library/',
		));

		$loader->register();
	}

	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	public function registerServices($di)
	{
		$config = include APP_PATH.'/apps/common/config/config.php';

		$di->set('dispatcher', function() use ($di) {

			$eventsManager = new \Phalcon\Events\Manager;

			/**
			 * Check if the user is allowed to access certain action using the SecurityPlugin
			 */
			//$eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin);

			/**
			 * Handle exceptions and not-found exceptions using NotFoundPlugin
			 */
			$eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);

			$dispatcher = new \Phalcon\Mvc\Dispatcher;
			$dispatcher->setEventsManager($eventsManager);

			$dispatcher->setDefaultNamespace("Chen\Manage\Controllers\\");
			return $dispatcher;
		});

		/**
		 * The URL component is used to generate all kind of urls in the application
		 */
		$di->set(
		    'url',
		    function () use ($di) {
		        $url = new \Phalcon\Mvc\Url();
		        if (!$di->get('config')->manage->debug) {
		            $url->setBaseUri($di->get('config')->manage->production->baseUri);
		            $url->setStaticBaseUri($di->get('config')->manage->production->staticBaseUri);
		        } else {
		            $url->setBaseUri($di->get('config')->manage->development->baseUri);
		            $url->setStaticBaseUri($di->get('config')->manage->development->staticBaseUri);
		        }
		    return $url;
		});

		//Registering the view component
		$di->set('view', function() {
			$view = new \Phalcon\Mvc\View();
			$view->setViewsDir('../apps/manage/views/');
			return $view;
		});

		//	session
		$di->set('session', function() {
		    $session = new \Phalcon\Session\Adapter\Files(
		    	array(
            		'uniqueId' => 'my-app-1'
        		)
		    );
		    $session->start();
		    return $session;
		});

		/*
		*   设置安全组件
		*   2015-1-26
		*/
		$di->set('security', function(){
			$security = new \Phalcon\Security();
			//Set the password hashing factor to 12 rounds
			$security->setWorkFactor(12);
			return $security;
		}, true);

		/**
		 *  Register the flash service with custom CSS classes
		 *  2015-1-26
		*/
		   
		$di->set('flash', function() {
		    $flash = new \Phalcon\Flash\Direct(array(
		        'error' => 'errorMessage',
		        'success' => 'successMessage',
		        'notice' => 'noticeMessage',
		        'warning' => 'warningMessage'
		    ));
		    return $flash;       
		});

		$di->set('flashSession',function () {
		    return new \Phalcon\Flash\Session(array(
		        'error' => 'errorMessage',
		        'success' => 'successMessage',
		        'notice' => 'noticeMessage',
		        'warning' => 'warningMessage'
		    ));
		    }
		);

		/**
		*   注册用户组件
		*   2015-1-26
		*/
		$di->set('elements', function(){
		    return new \Chen\Manage\Library\Elements();
		});

	}

}