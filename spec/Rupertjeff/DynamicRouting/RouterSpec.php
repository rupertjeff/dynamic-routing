<?php namespace spec\Rupertjeff\DynamicRouting;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rupertjeff\DynamicRouting\Contracts\RouteCreator;
use Rupertjeff\DynamicRouting\Contracts\Router;

class RouterSpec extends ObjectBehavior {

	function let(Router $router)
	{
		$this->beConstructedWith($router);
		$this->shouldHaveType('Rupertjeff\DynamicRouting\Router');
	}

	function it_creates_get_routes(Router $router, RouteCreator $creator)
	{
		$f = function ()
		{
			echo 'test';
		};
		$creator->getRouteInfo()->willReturn(array(
			array(
				'method' => 'get',
				'uri' => 'test',
				'action' => $f
			)
		));

		$this->create($creator);

		$router->get('test', $f)->shouldBeCalled();
	}

	function it_creates_post_routes(Router $router, RouteCreator $creator)
	{
		$f = function ()
		{
			echo 'test';
		};
		$creator->getRouteInfo()->willReturn(array(
			array(
				'method' => 'post',
				'uri' => 'test',
				'action' => $f
			)
		));

		$this->create($creator);

		$router->post('test', $f)->shouldBeCalled();
	}

	function it_creates_put_routes(Router $router, RouteCreator $creator)
	{
		$f = function ()
		{
			echo 'test';
		};
		$creator->getRouteInfo()->willReturn(array(
			array(
				'method' => 'put',
				'uri' => 'test',
				'action' => $f
			)
		));

		$this->create($creator);

		$router->put('test', $f)->shouldBeCalled();
	}

	function it_creates_delete_routes(Router $router, RouteCreator $creator)
	{
		$f = function ()
		{
			echo 'test';
		};
		$creator->getRouteInfo()->willReturn(array(
			array(
				'method' => 'delete',
				'uri' => 'test',
				'action' => $f
			)
		));

		$this->create($creator);

		$router->delete('test', $f)->shouldBeCalled();
	}

	function it_creates_routes_with_multiple_method_types(Router $router, RouteCreator $creator)
	{
		$f = function ()
		{
			echo 'test';
		};
		$creator->getRouteInfo()->willReturn(array(
			array(
				'method' => array('get', 'post'),
				'uri' => 'test',
				'action' => $f
			)
		));

		$this->create($creator);

		$router->match(array('get', 'post'), 'test', $f)->shouldBeCalled();
	}

	function it_requires_a_method(RouteCreator $creator)
	{
		$f = function ()
		{
			echo 'test';
		};
		$creator->getRouteInfo()->willReturn(array(
			array(
				'method' => null,
				'uri' => 'test',
				'action' => $f
			)
		));

		$this->shouldThrow('Rupertjeff\DynamicRouting\Exceptions\RouteMethodNotDefined')->during('create', array($creator));
	}

	function it_requires_a_uri(RouteCreator $creator)
	{
		$f = function ()
		{
			echo 'test';
		};
		$creator->getRouteInfo()->willReturn(array(
			array(
				'method' => 'get',
				'uri' => null,
				'action' => $f
			)
		));

		$this->shouldThrow('Rupertjeff\DynamicRouting\Exceptions\RouteUriNotDefined')->during('create', array($creator));
	}

	function it_requires_an_action(RouteCreator $creator)
	{
		$f = function ()
		{
			echo 'test';
		};
		$creator->getRouteInfo()->willReturn(array(
			array(
				'method' => 'get',
				'uri' => 'test',
				'action' => null
			)
		));

		$this->shouldThrow('Rupertjeff\DynamicRouting\Exceptions\RouteActionNotDefined')->during('create', array($creator));
	}

	function it_requires_that_the_router_has_the_requested_method(RouteCreator $creator)
	{
		$f = function ()
		{
			echo 'test';
		};
		$creator->getRouteInfo()->willReturn(array(
			array(
				'method' => 'foo',
				'uri' => 'test',
				'action' => $f
			)
		));

		$this->shouldThrow('Rupertjeff\DynamicRouting\Exceptions\RouterMethodNotDefined')->during('create', array($creator));
	}
}
