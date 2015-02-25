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

class Group extends Container
{
	public function __construct(Router $router)
	{
		$this->router = $router;
	}
}
