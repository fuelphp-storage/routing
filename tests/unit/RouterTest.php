<?php

use Fuel\Routing\Router;

class RouterTest extends \Codeception\TestCase\Test
{
	public function testPlainRouting()
	{
		$router = new Router;
		$router->get('route', 'translation', 'name');
		$router->get('route', 'tranation');
		$route = $router->get('name');
		$this->assertInstanceOf('Fuel\Routing\Route', $route);
	}
}
