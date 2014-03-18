<?php namespace Rupertjeff\DynamicRouting\Contracts;

interface RouteCreator {

	/**
	 * Anything creating a route will need this function. This should return info
	 * that defines any routes that should be created. Each item should be either
	 * an object (stdClass) or array that has 3 pieces of information:
	 *   - uri    string                 Uri for the new route
	 *   - method string|array           A method name or list of method names
	 *                                   for the new route
	 *   - action string|array|Callable  Action to be called when the new route
	 *                                   hits.
	 *
	 * @return array|\ArrayAccess
	 */
	public function getRouteInfo();
}
