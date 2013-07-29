<?php

namespace Fuel\Routing;

use Closure;

abstract class Container
{
	public $router;

	public $prefix = '';

	public $routes = array();

	public function __construct($prefix = null)
	{
		if ($prefix)
		{
			$this->prefix = trim($prefix, '/').'/';
		}
	}

	public function route($methods, $resource, $translation = null, $name = null)
	{
		$resource = $this->prefix.trim($resource, '/');

		if (is_string($methods))
			$methods = explode('|', strtoupper($methods));

		$router = $this->router ?: $this;
		$route = new Route($router, $methods, $resource, $translation, $name);

		if ($name)
		{
			$this->routes[$name] = $route;
		}
		else
		{
			$this->routes[] = $route;
		}

		return $route;
	}

	public function get($resource, $translation = null, $name = null)
	{
		return $this->route(['GET'], $resource, $translation, $name);
	}

	public function post($resource, $translation = null, $name = null)
	{
		return $this->route(['POST'], $resource, $translation, $name);
	}

	public function patch($resource, $translation = null, $name = null)
	{
		return $this->route(['PATCH'], $resource, $translation, $name);
	}

	public function put($resource, $translation = null, $name = null)
	{
		return $this->route(['PUT'], $resource, $translation, $name);
	}

	public function delete($resource, $translation = null, $name = null)
	{
		return $this->route(['DELETE'], $resource, $translation, $name);
	}

	public function getRoute($name)
	{
		if (isset($this->routes[$name]))
		{
			return $this->routes[$name];
		}
	}

	public function inject(Route $route)
	{
		if ($route->name)
		{
			$this->routes[$route->name] = $route;
		}
		else
		{
			$this->routes[] = $route;
		}

		return $this;
	}

	public function provide(Container $container, array $filters = array())
	{
		foreach ($this->routes as $route)
		{
			$route->filters += $filters;

			$container->inject($route);
		}
	}

	public function group(Closure $callback, array $filters = array())
	{
		// Create a new route collection with the correct parent.
		$group = new Group($this->router ?: $this);

		// Execute the callback, supplying the group
		call_user_func($callback, $group);

		// Provider the routes to it's parent.
		$group->provide($this, $filters);

		return $this;
	}

	public function addCollection(Collection $collection)
	{
		$collection->provide($this);

		return $this;
	}
}