<?php
	use \Phalcon\Mvc\Router;
	//Registering a router
	$di->set('router', function(){

		$router = new Router();

		//Remove trailing slashes automatically
		$router->removeExtraSlashes(true);

		//$router->setUriSource(Router::URI_SOURCE_GET_URL); // use $_GET['_url'] (default)
		$router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
			
		//$router->setDefaultModule("frontend");

		$router->add('/', array(
			'module' => 'frontend',
			'controller' => 'index',
			'action' => 'index',
		));

		$router->add('/:controller', array(
			'module' => 'frontend',
			'controller' => 1,
			'action' => 'index',
		));

		$router->add('/:controller/:action', array(
			'module' => 'frontend',
			'controller' => 1,
			'action' => 2,
		));

		$router->add('/:controller/:action/:params', array(
			'module' => 'frontend',
			'controller' => 1,
			'action' => 2,
			'params' => 3
		));

		$router->add('/{post}.html', array(
		 	'module' => 'frontend',
		 	'controller' => 'posts',
		 	'action' => 'index'
		))->setName('show-post');

		$router->add('/{types}/{post}.html', array(
			'module' => 'frontend',
			'controller' => 'posts',
			'action' => 'index'
		));

		$router->add('/category/{category}', array(
			'module' => 'frontend',
			'controller' => 'index',
			'action' => 'index'
		))->setName('show-post');

		$router->add('/tag/{tag}', array(
			'module' => 'frontend',
			'controller' => 'index',
			'action' => 'index'
		))->setName('show-post');


		$router->add('/manage', array(
			'module' => 'manage',
			'controller' => 'index',
			'action' => 'index',
		));

		$router->add('/manage/:controller', array(
			'module' => 'manage',
			'controller' => 1,
			'action' => 'index',
		));

		$router->add('/manage/:controller/:action', array(
			'module' => 'manage',
			'controller' => 1,
			'action' => 2,
		));

		$router->add('/manage/:controller/:action/:params', array(
			'module' => 'manage',
			'controller' => 1,
			'action' => 2,
			'params' => 3,
		));

		//	图片处理 Start

		// $router->add('/imageView/:params', array(
		// 	'module' => 'manage',
		// 	'controller' => 'picture',
		// 	'action' => 'imageView',
		// 	'params' => 1,
		// ));

		// $router->add('/imageView', array(
		// 	'module' => 'manage',
		// 	'controller' => 'index',
		// 	'action' => 'index',
		// ));
		//	图片处理 End

		$router->notFound(array(
     		'module' => 'frontend',
     		"controller" => "error",
     		"action" => "error404"
		));

		return $router;

	});