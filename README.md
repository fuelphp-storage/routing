Routing
=======

FuelPHP Framework - Request Routing library

[![Build Status](https://travis-ci.org/fuelphp/routing.svg?branch=master)](https://travis-ci.org/fuelphp/routing)
[![Code Coverage](https://scrutinizer-ci.com/g/fuelphp/routing/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/fuelphp/routing/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fuelphp/routing/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fuelphp/routing/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/fuelphp/routing.svg)](http://hhvm.h4cc.de/package/fuelphp/routing)

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
