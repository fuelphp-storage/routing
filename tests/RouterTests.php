<?php

use Fuel\Routing\Router;

class RouterTests extends PHPUnit_Framework_TestCase
{
	public function testPlainRouting()
	{
		$router = new Router;
		$router->get('route', 'translation', 'name');
		$route = $router->get('name');
		$this->assertInstanceOf('Fuel\Routing\Route', $route);
	}
}