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

class Parameter
{
	public $default;
	public $name;
	public $regex;
	public $route;
	public $optional;

	public function __construct(Route $route = null, $name, $regex, $optional = false)
	{
		$this->route = $route;
		$this->name = $name;
		$this->regex = $regex;
		$this->optional = $optional;
	}

	public function isOptional($optional = true)
	{
		$this->optional = $optional;

		return $this;
	}

	public function setDefault($default)
	{
		$this->default = $default;

		return $this;
	}

	public function matches($regex)
	{
		$this->regex = $regex;

		return $this;
	}

	public function getRegex()
	{
		$regex = '(?P<'.$this->name.'>'.$this->regex.')';

		if ($this->optional)
		{
			$regex = '(?:'.$regex.')?';
		}

		return $regex;
	}

	public function parameter()
	{
		if ( ! $this->route)
		{
			throw new \LogicException('Parameter chaining required a $route object to be set.');
		}

		return call_user_func_array(array($this->route, 'parameter'), func_get_args());
	}
}