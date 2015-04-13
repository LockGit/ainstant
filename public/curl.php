<?php

require_once 'src/Unirest.php';

$response = Unirest\Request::get('http://localhost/upload/temp/733181708fe67fe6888be35ef782d1df-720x500.jpg');

        //$this->assertEquals(200, $response->code);
        //$this->assertEquals('GET', $response->body->method);
        //$this->assertEquals('Mark', $response->body->queryString->name);
        //$this->assertEquals('thefosk', $response->body->queryString->nick);

header('content-type: image/png');
echo $response->raw_body;
?>