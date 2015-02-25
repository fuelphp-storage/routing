# Fuel Routing

[![Build Status](https://img.shields.io/travis/fuelphp/routing.svg?style=flat-square)](https://travis-ci.org/fuelphp/routing)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/fuelphp/routing.svg?style=flat-square)](https://scrutinizer-ci.com/g/fuelphp/routing)
[![Quality Score](https://img.shields.io/scrutinizer/g/fuelphp/routing.svg?style=flat-square)](https://scrutinizer-ci.com/g/fuelphp/routing)
[![HHVM Status](https://img.shields.io/hhvm/fuelphp/routing.svg?style=flat-square)](http://hhvm.h4cc.de/package/fuelphp/routing)

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

Besides defining the filter per route definition manually, you can also define an autofilter, which is something callable that will
convert the translated route into a controller and action.
