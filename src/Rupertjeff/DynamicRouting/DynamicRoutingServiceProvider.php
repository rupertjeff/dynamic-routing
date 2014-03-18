<?php namespace Rupertjeff\DynamicRouting;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class DynamicRoutingServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Rupertjeff\DynamicRouting\Contracts\Router', 'Rupertjeff\DynamicRouting\Laravel\Router');

		$this->app['routeCreator'] = $this->app->share(function (Application $app)
		{
			return new Router($app->make('Rupertjeff\DynamicRouting\Contracts\Router'));
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
