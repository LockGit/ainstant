<?php
namespace Chen\Frontend;

use Chen\Plugins\NotFoundPlugin;

//use Chen\Frontend\Plugins\Content;

class Module
{

	public function registerAutoloaders()
	{

		$loader = new \Phalcon\Loader();

		$loader->registerDirs(
		 	array(
		 		//'../apps/common/abc/'
		 	)
		)->register();

		if ($this->is_mobile()) {
			$namespace = 'Chen\Frontend\Wap\Controllers';
			$path = '../apps/frontend/wap/controllers/';
		} else {
			$namespace = 'Chen\Frontend\Web\Controllers';
			$path = '../apps/frontend/web/controllers/';
		}

		$loader->registerNamespaces(array(
			
			$namespace 				=> $path,
			'Chen\Frontend\Models'  => '../apps/frontend/models/',
			'Chen\Frontend\Library' => '../apps/frontend/library/',
			'Chen\Frontend\Plugins' => '../apps/frontend/plugins/',
			
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
			
			if ($this->is_mobile()) {
				$dispatcher->setDefaultNamespace("Chen\Frontend\Wap\Controllers\\");
			} else {
				$dispatcher->setDefaultNamespace("Chen\Frontend\Web\Controllers\\");
			}
			
			return $dispatcher;
		});

		/**
		 * The URL component is used to generate all kind of urls in the application
		 */
		$di->set(
		    'url',
		    function () use ($config) {
		        $url = new \Phalcon\Mvc\Url();
		        if (!$config->frontend->debug) {
		            $url->setBaseUri($config->frontend->production->baseUri);
		            $url->setStaticBaseUri($config->frontend->production->staticBaseUri);
		        } else {
		            $url->setBaseUri($config->frontend->development->baseUri);
		            $url->setStaticBaseUri($config->frontend->development->staticBaseUri);
		        }
		    return $url;
		});

		if ($this->is_mobile()) {

			$di->set('view', function() {
				$view = new \Phalcon\Mvc\View();
				$view->setViewsDir('../apps/frontend/wap/views/');
				return $view;
			});

		} else {

			$di->set('view', function() {
				$view = new \Phalcon\Mvc\View();
				$view->setViewsDir('../apps/frontend/web/views/');
				return $view;
			});
		}

		//	session
		$di->set('session', function() {
		    $session = new \Phalcon\Session\Adapter\Files(
		    	array(
            		'uniqueId' => 'my-app-2'
        		)
		    );
		    $session->start();
		    return $session;
		});

		/**
		*   注册用户组件
		*   2015-1-26
		*/
		$di->set('elements', function(){
		    return new \Chen\Frontend\Library\Elements();
		});

	}


	protected function is_mobile() {
		static $is_mobile;

		if ( isset($is_mobile) )
			return $is_mobile;

		if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
			$is_mobile = false;
		} elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
			|| strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
			|| strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
			|| strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
			|| strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
			|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
			|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
				$is_mobile = true;
		} else {
			$is_mobile = false;
		}

		return $is_mobile;
	}

}

//new Content;