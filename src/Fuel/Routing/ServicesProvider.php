<?php
/**
 * @package    Fuel\Routing
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Routing;

use Fuel\Dependency\ServiceProvider;

/**
 * ServicesProvider class
 *
 * Defines the services published by this namespace to the DiC
 *
 * @package  Fuel\Routing
 *
 * @since  1.0.0
 */
class ServicesProvider extends ServiceProvider
{
	/**
	 * @var  array  list of service names provided by this provider
	 */
	public $provides = array('router');

	/**
	 * Service provider definitions
	 */
	public function provide()
	{
		// \Fuel\Routing\Router
		$this->register('router', function ($dic)
		{
			return new Router();
		});
	}
}
