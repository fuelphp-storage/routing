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