<?php

namespace Fuel\Routing;

use LogicException;

class Route
{
	public $name;
	public $router;
	public $methods;
	public $resource;
	public $translation;
	public $parameters = array();
	public $filters = array();

	public function __construct(Router $router, array $methods, $resource, $translation, $name)
	{
		$this->name = $name;
		$this->router = $router;
		$this->methods = $methods;
		$this->resource = $resource;

		if (is_array($translation))
		{
			$this->filters($translation);
			$translation = '';
		}

		$this->translation = $translation;
	}

	public function filters(array $filters)
	{
		$normalized = array();

		foreach ($filters as $filter => $parameters)
		{
			if (is_numeric($filter))
			{
				$normalized[$parameters] = [true];
			}
			else
			{
				$normalized[$filter] = (array) $parameters;
			}
		}

		$this->filters = array_merge($this->filters, $normalized);

		return $this;
	}

	public function filter($filter, $parameters = true)
	{
		$this->filters[$filter] = (array) $parameters;

		return $this;
	}

	public function parameter($parameter, $regex = '(.*)+')
	{
		if (is_string($parameter))
		{
			$parameter = new Parameter($this, $parameter, $regex);
		}

		$this->parameters[$parameter->name] = $parameter;

		return $parameter;
	}

	public function compileRegex()
	{
		$search = [];
		$replace = [];

		// Convert al named parameters the user
		// has specified as.
		foreach ($this->parameters as $parameter)
		{
			$search[] = '{'.$parameter->name.'}';
			$replace[] = $parameter->getRegex();
		}

		$regex = str_replace($search, $replace, $this->resource);

		// Convert remaining named parameters
		$regex = preg_replace('#\{([a-z\_]+)\}#', '(?P<$1>.+?)', $regex);

		return '#^'.$regex.'$#';
	}

	public function match($uri, $method)
	{
		if ($method !== '*' and ! in_array($method, $this->methods))
		{
			return false;
		}

		$regex = $this->compileRegex();

		if ( ! preg_match($regex, $uri, $matches))
		{
			return false;
		}

		$translation = $this->translation;
		$parameters = $this->filterNamedParameters($matches);

		if (is_string($translation))
		{
			$translation = preg_replace($regex, $translation, $uri);
			$translation = str_replace('#/{2,}#', '/', $translation);
		}

		return new Match($this, $method, $uri, $translation, $parameters, $this->name);
	}

	public function filterNamedParameters(array $parameters)
	{
		foreach ($parameters as $key => $value)
		{
			if (is_numeric($key))
			{
				unset($parameters[$key]);
			}
		}

		return $parameters + $this->getDefaultNamedParameters();
	}

	public function getParameterDefault($name, $strict = true)
	{
		if ( ! isset($this->parameters[$name]))
		{
			return null;
		}

		$parameter = $this->parameters[$name];

		if ($parameter->optional)
		{
			return '';
		}

		return $parameter->default;
	}

	public function getDefaultNamedParameters()
	{
		return array_map(function ($parameter)
		{
			return $parameter->default;
		},
		$this->parameters);
	}

	public function compile(array $parameters = array())
	{
		$resource = $this->resource;

		$callback = function ($match) use ($parameters)
		{
			if (isset($parameters[$match[1]]))
			{
				return $parameters[$match[1]];
			}

			if ($default = $this->getParameterDefault($match[1]))
			{
				return $default;
			}

			throw new LogicException('Could not resolve parameter ['.$match[1].'] for route ['.$this->name.']');
		};

		return preg_replace_callback('#\{([a-zA-Z_-]+)\}#', $callback,	$this->resource);
	}
}