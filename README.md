Routing
=======

FuelPHP Framework - Request Routing library

Sample code

```php
<?php

include "./vendor/autoload.php";

use Fuel\Routing\Router;

$router = new Router;
$router->setType('string', Router::MATCH_ANY);
$router->setType('num', Router::MATCH_NUM);
$router->setType('int', Router::MATCH_NUM);

$router->all('/')->filters([
		'controller' => 'SomeController',
		'action' => 'someAction',
	]);

$router->post('users')->filters([
		'controller' => 'UserController',
		'action' => 'create',
	]);

$router->get('users')->filters([
		'controller' => 'UserController',
		'action' => 'index',
	]);

$router->put('users/{int:id}')->filters([
		'controller' => 'UserController',
		'action' => 'update',
	]);

var_dump($router->translate('users/123', 'PUT'));
```
