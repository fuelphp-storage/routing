<?php
/**
 * @package    Fuel\Routing
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Routing\Providers;

use League\Container\ServiceProvider;

/**
 * Fuel ServiceProvider class for Routing
 *
 * @package Fuel\Routing
 *
 * @since 2.0
 */
class FuelServiceProvider extends ServiceProvider
{
	/**
	 * @var array
	 */
	protected $provides = [];

	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
	}
}
