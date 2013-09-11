<?php

include 'vendor/autoload.php';

use Fuel\Routing\Router;

$router = new Router;
$router->setType('string', Router::MATCH_ANY);
$router->setType('num', Router::MATCH_NUM);
$router->setType('int', Router::MATCH_NUM);

$router->get('/{name}/is/{string:type}', 'controller/user/name/$1/$2', 'route_name')
	->name('new_name')
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


$route = $router->getRoute('new_name')->compile([
	'name' => 'frank',
	'type' => 'een-beetje-gek',
]);



echo $route;

var_dump($router->translate($route, 'GET'));
$m = $router->translate('/john/is/mad', 'GET');
var_dump($m);


