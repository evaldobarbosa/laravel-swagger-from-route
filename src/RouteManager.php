<?php
namespace SwaggerFromRoute;

class RouteManager
{
	private $routes;
	private $exceptions;

	public function __construct()
	{
		// $config = config('sfroute.exceptions');
		// if (is_null($config)) {
		// 	$config = require(__DIR__ . "/../config/sfroute.php");
		// }

		$this->exceptions = config('sfroute.exceptions');
	}

	public function setExceptions($exceptions)
	{
		$this->exceptions = $exceptions;

		return $this;
	}

	public function setRoutes($routes)
	{
		$this->routes = $routes;

		return $this;
	}

	private function removeExceptions()
	{
		$routes = $this->routes;

		[$startedWith, $fullNamed] = collect($this->exceptions)
		->sort()
		->partition(function ($item) {
			return str($item)->endsWith('*');
		});

		$startedWith = $startedWith->map(function ($item) {
			return str($item)->before('*');
		});

		$routes = collect($routes)->filter(function($item) use ($fullNamed) {

			return !in_array($item->uri, $fullNamed->toArray());

		})->filter(function($item) use ($startedWith) {

			return $startedWith->filter(function($uri) use ($item) {
				return str($item->uri)->startsWith($uri);
			})->count() == 0;

		});

		return $routes;
	}

	public function validRoutes()
	{
		$routes = $this->removeExceptions();

		return $routes;
	}
}
