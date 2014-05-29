<?php

namespace Fuel\Routing;

use Closure;
use LogicException;

class Router extends Container
{
	const MATCH_ANY = '.+';
	const MATCH_NUM = '[[:digit:]]+';
	const MATCH_ALNUM = '[[:alnum:]]+';
	const MATCH_ALPHA = '[[:alpha:]]+';
	const MATCH_SEGMENT = '[^/]*';

	protected $filters = array();

	protected $autoFilter = null;

	public function setAutoFilter($filter)
	{
		$this->autoFilter = $filter;

		return $this;
	}

	public function filter($filter, Closure $callback)
	{
		$this->filters[$filter] = $callback;

		return $this;
	}

	public function applyFilters(Match $match, array $filters)
	{
		foreach ($filters as $filter => $parameters)
		{
			array_unshift($parameters, $match);
			$filter = $this->resolveFilter($filter);
			$result = call_user_func_array($filter, $parameters);

			if ($result === null or $result === true)
			{
				continue;
			}

			if ($result === false)
			{
				return false;
			}

			$match->response = $result;

			break;
		}

		return $match;
	}

	public function applyAutoFilter(Match $match)
	{
		return call_user_func($this->autoFilter, $match);
	}

	public function resolveFilter($name)
	{
		if (isset($this->filters[$name]))
		{
			return $this->filters[$name];
		}

		$method = 'filter'.ucfirst($name);

		if (method_exists($this, $method))
		{
			return array($this, $method);
		}

		throw new LogicException('Could not find filter: '.$name);
	}

	public function filterDomain(Match $match, $domain)
	{
		return $_SERVER['SERVER_NAME'] === $domain;
	}

	public function filterNamespace(Match $match, $namespace)
	{
		$match->setNamespace($namespace);
	}

	public function filterController(Match $match, $controller)
	{
		$match->setController($controller);
	}

	public function filterAction(Match $match, $action)
	{
		$match->setAction($action);
	}

	public function filterTo(Match $match, $to)
	{
		list($controller, $action) = explode('@', $to);

		$match->setController($controller);
		$match->setAction($action);
	}

	public function translate($uri, $method)
	{
		$uri = trim($uri, '/');

		foreach ($this->routes as $route)
		{
			if ($match = $this->match($route, $uri, $method))
			{
				return $match;
			}
		}

		return new Match(null, $method, $uri, $uri);
	}

	public function match(Route $route, $uri, $method = '*')
	{
		if ($match = $route->match($uri, $method))
		{
			if ($route->filters)
			{
				return $this->applyFilters($match, $route->filters);
			}
			elseif ($this->autoFilter)
			{
				return $this->applyAutoFilter($match);
			}
			return $match;
		}
	}
}
