<?php

include 'vendor/autoload.php';

use Fuel\Routing\Router;

$router = new Router;

$router->group(function($router) {
	$router->get('/{name}/is/{type}', 'controller/user/name/$1/$2', 'route_name')
		->filters([
			'controller' => 'Controller\\Something',
			'domain' => 'routing.dev',
		]);

	$router->post('/{name}/is/{type}', 'post/user/name/$1');
	$router->get('/', function ($request) {
		return 'this!';
	})->filters([
		'domain' => 'routing.dev',
		'to' => 'Controller\\Something@actionIndex',
	]);
}, [
	'domain' => 'something.dev',
]);

$route = $router->getRoute('route_name')->compile([
	'name' => 'frank',
	'type' => 'een-beetje-gek',
]);



echo $route;

var_dump($router->translate($route, 'GET'));
$m = $router->translate('/', 'GET');
var_dump($m);


