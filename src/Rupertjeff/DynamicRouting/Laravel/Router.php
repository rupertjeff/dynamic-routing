<?php namespace Rupertjeff\DynamicRouting\Laravel;

use Route;
use Rupertjeff\DynamicRouting\Contracts\Router as RouterInterface;

/**
 * Class Router
 * @package Rupertjeff\DynamicRouting\Laravel
 *
 * Connection to \Illuminate\Routing\Router
 * Implements \Rupertjeff\DynamicRouting\Support\Contracts\Router
 */
class Router implements RouterInterface {

	public function get($uri, $action)
	{
		Route::get($uri, $action);
	}

	public function post($uri, $action)
	{
		Route::post($uri, $action);
	}

	public function put($uri, $action)
	{
		Route::put($uri, $action);
	}

	public function patch($uri, $action)
	{
		Route::patch($uri, $action);
	}

	public function delete($uri, $action)
	{
		Route::delete($uri, $action);
	}

	public function options($uri, $action)
	{
		Route::options($uri, $action);
	}

	public function match($methods, $uri, $action)
	{
		Route::match($methods, $uri, $action);
	}

}
