<?php

namespace Fuel\Routing;

class Collection extends Container
{
	public function __construct(Router $router)
	{
		$this->router = $router;
	}
}