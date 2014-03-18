# Dynamic Routing

[![Build Status](https://travis-ci.org/rupertjeff/dynamic-routing.png?branch=0.2.1)](https://travis-ci.org/rupertjeff/dynamic-routing)

I’ve found that I often times need to have functionality for client/CMS defined routing in my sites, so I put together a quick library that deals with the creation of said routes.

## Usage

You can pull the package in through Composer:

	{
		"require": {
			"rupertjeff/dynamic-routing": "dev-master"
		}
	}

Once the package exists and it’s being loaded into your project, create an instance of `Rupertjeff\DynamicRouting\Contracts\RouteCreator`. Give that to this package and it’ll go from there!

	// Where $creator is an instance of Rupertjeff\DynamicRouting\Contracts\RouteCreator
	DynamicRouter::create($creator)

### Laravel 4

If you’re using Laravel 4 (as I do, mostly), you can add the included ServiceProvider and Facade to make things easier for you. Just add

	'Rupertjeff\DynamicRouting\Laravel\DynamicRoutingServiceProvider'

to your `'providers'` array in `./app/config/app.php`, and

	'DynamicRouter' => 'Rupertjeff\DynamicRouting\Laravel\Facade'

to your `'aliases'` array. Don’t like the Laravel Facade approach? Grab it off of `$this->app['dynamicRouter']` or create your own out of the IoC container.

### Other Projects

Create an implementation of `Rupertjeff\DynamicRouting\Contract\Router` and make sure to create a `Rupertjeff\DynamicRouting\Router` with that first class as the first parameter to the constructor.

	// Where $router is an instance of Rupertjeff\DynamicRouting\Contract\Router
	$dynamicRouter = new Rupertjeff\DynamicRouting\Router($router);

Then just call

	// Where $creator is an instance of Rupertjeff\DynamicRouting\Contracts\RouteCreator
	$dynamicRouter->create($creator);

That’s it!

## Contributing

Please send me any issues/pull requests as you find issues, etc. I’m always wanting feedback on my code as well, so mention something if you see it.

## License

This Dynamic Router is open sourced and licensed under the [MIT License](http://opensource.org/licenses/MIT).
