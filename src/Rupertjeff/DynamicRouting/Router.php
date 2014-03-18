<?php namespace Rupertjeff\DynamicRouting;

use Rupertjeff\DynamicRouting\Contracts\RouteCreator as RouteCreatorInterface;
use Rupertjeff\DynamicRouting\Contracts\Router as RouterInterface;
use Rupertjeff\DynamicRouting\Exceptions\RouterMethodNotDefined as RouterMethodNotDefinedException;
use Rupertjeff\DynamicRouting\Exceptions\RouteActionNotDefined as RouteActionNotDefinedException;
use Rupertjeff\DynamicRouting\Exceptions\RouteCreatorNull as RouteCreatorNullException;
use Rupertjeff\DynamicRouting\Exceptions\RouteMethodNotDefined as RouteMethodNotDefinedException;
use Rupertjeff\DynamicRouting\Exceptions\RouteUriNotDefined as RouteUriNotDefinedException;

class Router {

	/**
	 * @var RouterInterface
	 */
	protected $router;

	/**
	 * @var RouteCreatorInterface
	 */
	protected $creator;

	/**
	 * @param RouterInterface       $router
	 * @param RouteCreatorInterface $creator
	 */
	public function __construct(RouterInterface $router, RouteCreatorInterface $creator = null)
	{
		$this->setRouter($router);

		if ( ! is_null($creator))
		{
			$this->setCreator($creator);
		}
	}

	/**
	 * The main method that delegates work to make the route itself. Can accept
	 * a specific RouteCreatorInterface to use for one call to create. If any
	 * required information is missing, it will throw an Exception and stop
	 * progressing through the Routes to be generated.
	 *
	 * @param RouteCreatorInterface $creator
	 *
	 * @throws RouterMethodNotDefinedException
	 * @throws RouteMethodNotDefinedException
	 * @throws RouteUriNotDefinedException
	 * @throws RouteActionNotDefinedException
	 * @throws RouteCreatorNullException
	 */
	public function create(RouteCreatorInterface $creator = null)
	{
		if ( ! is_null($creator))
		{
			$this->setCreator($creator);
		}

		if (is_null($this->creator))
		{
			throw new RouteCreatorNullException;
		}

		foreach ($this->creator->getRouteInfo() as $r)
		{
			list($method, $uri, $action) = $this->parseRoute($r);

			$this->makeRoute($method, $uri, $action);
		}
	}

	/**
	 * Take the route as a whole and break it into the required pieces.
	 * Basically, the only pieces that matter are method(s), uri, and action.
	 * Anything else can safely be ignored and not touched.
	 *
	 * @param $route
	 *
	 * @throws RouterMethodNotDefinedException
	 * @throws RouteMethodNotDefinedException
	 * @throws RouteUriNotDefinedException
	 * @throws RouteActionNotDefinedException
	 * @return array
	 */
	protected function parseRoute($route)
	{
		if ( ! is_array($route))
		{
			$route = (array)$route;
		}

		list($method, $uri, $action) = $this->getRoutePieces($route);

		$this->validateRoute($method, $uri, $action);

		return array($method, $uri, $action);
	}

	/**
	 * Filters out any unneeded information from the $route itself.
	 *
	 * @param array $route
	 *
	 * @return array
	 */
	protected function getRoutePieces(array $route)
	{
		return array(
			$route['method'], $route['uri'], $route['action']
		);
	}

	/**
	 * Checks to make sure we can create a valid route out of the given info.
	 * DOES NOT check to make sure the route does not yet exist, etc. That is
	 * outside of the scope of this tool.
	 *
	 * @param $method
	 * @param $uri
	 * @param $action
	 *
	 * @throws RouterMethodNotDefinedException
	 * @throws RouteMethodNotDefinedException
	 * @throws RouteUriNotDefinedException
	 * @throws RouteActionNotDefinedException
	 */
	protected function validateRoute($method, $uri, $action)
	{
		if (empty($method))
		{
			throw new RouteMethodNotDefinedException;
		}
		if (is_string($method) && ! method_exists($this->router, $this->getMethodName($method)))
		{
			throw new RouterMethodNotDefinedException;
		}
		if (empty($uri))
		{
			throw new RouteUriNotDefinedException;
		}
		if (empty($action))
		{
			throw new RouteActionNotDefinedException;
		}
	}

	/**
	 * Create the route based on how the default Application wants to do routes.
	 *
	 * @param string|array          $method
	 * @param string                $uri
	 * @param string|array|Callable $action
	 */
	protected function makeRoute($method, $uri, $action)
	{
		if (is_array($method))
		{
			$this->router->match($method, $uri, $action);
		}
		else
		{
			$f = $this->getMethodName($method);
			$this->router->$f($uri, $action);
		}
	}

	/**
	 * Assume methods will be camel-cased, but information given might not be.
	 *
	 * @param string $method
	 *
	 * @return string
	 */
	protected function getMethodName($method)
	{
		return camel_case($method);
	}

	/**
	 * @param RouteCreatorInterface $creator
	 */
	public function setCreator(RouteCreatorInterface $creator)
	{
		$this->creator = $creator;
	}

	/**
	 * @return RouterInterface
	 */
	public function getRouter()
	{
		return $this->router;
	}

	/**
	 * @param RouterInterface $router
	 */
	public function setRouter(RouterInterface $router)
	{
		$this->router = $router;
	}
}
