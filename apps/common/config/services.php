<?php

$di->set('db', function() use ($config) {
	$dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
	return new $dbclass(array(
		"host"     => $config->database->host,
		"username" => $config->database->username,
		"password" => $config->database->password,
		"dbname"   => $config->database->dbname,
		"charset"  => "utf8"
	));
});

/*
$di->set('db',function () use ($config) {

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config->database->toArray());

        $debug = $config->manage->debug;
        if ($debug) {

            $eventsManager = new \Phalcon\Events\Manager();

            $logger = new \Phalcon\Logger\Adapter\File(APP_PATH . '/apps/common/logs/db.log');
            
            $eventsManager->attach(
                'db',
                function ($event, $connection) use ($logger) {
                   
                    if ($event->getType() == 'beforeQuery') {
                        
                        $variables = $connection->getSQLVariables();
                        if ($variables) {
                            $logger->log($connection->getSQLStatement() . ' [' . join(',', $variables) . ']', \Phalcon\Logger::INFO);
                        } else {
                            $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
                        }
                    }
                }
            );
           
            $connection->setEventsManager($eventsManager);
        }

        return $connection;
    }
);

*/
//Registering the Models-Metadata
//$di->set('modelsMetadata', function(){
//    return new \Phalcon\Mvc\Model\Metadata\Memory();
    /*
    $metaData = new \Phalcon\Mvc\Model\Metadata\Files(array(
        'metaDataDir' => APP_PATH . '/apps/common/cache/'
    ));

    return $metaData;
    */
//});

//Registering the Models Manager
$di->set('modelsManager', function(){
    return new \Phalcon\Mvc\Model\Manager();
});

//设置模型缓存服务
//$di->set('modelsCache', function() {

    //默认缓存时间为一天
//    $frontCache = new \Phalcon\Cache\Frontend\Data(array(
//        'lifetime' => 86400
//    ));

//    $cache = new \Phalcon\Cache\Backend\File($frontCache, array(
//        'cacheDir' => APP_PATH . '/apps/common/cache/'
//    ));

//    return $cache;
//});

//Set the views cache service
//$di->set('viewCache', function() {

    //Cache data for one day by default
//    $frontCache = new \Phalcon\Cache\Frontend\Output(array(
//        "lifetime" => 86400
//    ));

    //Memcached connection settings
    /*
    $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
        "host" => "localhost",
        "port" => "11211"
    ));
    */
//    $cache = new \Phalcon\Cache\Backend\File($frontCache, array(
//        'cacheDir' => APP_PATH . '/apps/common/cache/'
//    ));

//    return $cache;
//});
