<?php

error_reporting(E_ALL);

$debug = new \Phalcon\Debug();
$debug->listen();

//	设置默认时区
date_default_timezone_set("Asia/Shanghai");

//	设置根目录
define('APP_PATH', realpath('..'));

define('CHARSET', 'UTF-8');

class Application extends \Phalcon\Mvc\Application
{

	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	protected function _registerServices()
	{

		//	读取配置文件
		$config = include APP_PATH.'/apps/common/config/config.php';
		
		define('APP_URL', $config->site->url);
		define('APP_IMAGE_URL', $config->site->image_url);

		$di = new \Phalcon\DI\FactoryDefault();

		$di->set('config', $config);

		//	自动加载
		$loader = new \Phalcon\Loader();

		// $loader->registerDirs(
		// 	array(
		// 		'../apps/common/library/',
		// 		'../apps/common/plugins/'
		// 	)
		// )->register();

		$loader->registerNamespaces(array(
			'Chen\Models' => '../apps/common/models/',
			'Chen\Plugins' => '../apps/common/plugins/',
			'Chen\library' => '../apps/common/library/'			
		));

		$loader->register();

		//	读取路由配置
		require '../apps/common/config/router.php';

		require '../apps/common/config/services.php';

		$this->setDI($di);
	}

	public function main()
	{

		$this->_registerServices();

		//Register the installed modules
		$this->registerModules(array(
			'frontend' => array(
			 	'className' => 'Chen\Frontend\Module',
			 	'path' => '../apps/frontend/Module.php'
			),
			'manage' => array(
				'className' => 'Chen\Manage\Module',
				'path' => '../apps/manage/Module.php'
			)
		));

		echo $this->handle()->getContent();

	}

}

//try {

$application = new Application();
$application->main();

// } catch(\Phalcon\Exception $e) {
//      echo "PhalconException: ", $e->getMessage();

//      /**
//      * Log the exception
//      */
//     //$logger = new Logger(APP_PATH . '/app/logs/error.log');
//     //$logger->error($e->getMessage());
//     //$logger->error($e->getTraceAsString());

//     /**
//      * Show an static error page
//      */
//     $response = new \Phalcon\http\Response();
//     $response->redirect('../errors/show500');
//     $response->send();
// }