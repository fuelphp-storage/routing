<?php
/**
 * @package    Fuel\Routing
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Routing;

class Match
{
	public $uri;
	public $name;
	public $action;
	public $method;
	public $translation;
	public $parameters;
	public $response;
	public $namespace;
	public $controller;

	public function __construct(Route $route = null, $method, $uri, $translation, array $parameters = array(), $name = null)
	{
		$this->uri = $uri;
		$this->name = $name;
		$this->route = $route;
		$this->method = $method;
		$this->translation = $translation;
		$this->parameters = $parameters;
	}

	public function setNamespace($namespace)
	{
		$this->namespace = trim($namespace, '\\').'\\';

		return $this;
	}

	public function setController($controller)
	{
		$this->controller = trim($controller, '\\');

		return $this;
	}

	public function setAction($action)
	{
		$this->action = $action;
	}

	public function getSegments()
	{
		return explode('/', $this->uri);
	}
}
