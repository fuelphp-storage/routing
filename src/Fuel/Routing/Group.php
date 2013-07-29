<?php

namespace Fuel\Routing;

class Group extends Container
{
	public function __construct(Router $router)
	{
		$this->router = $router;
	}
}