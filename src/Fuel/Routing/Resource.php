<?php

namespace Fuel\Routing;

class Resource
{
	protected $path;

	public function __construct($path)
	{
		$this->path = $path;
	}

	public function load(Router $router)
	{
		include $this->path;
	}
}