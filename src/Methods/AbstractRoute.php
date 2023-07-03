<?php
namespace SwaggerFromRoute\Methods;

use SwaggerFromRoute\Response;
use Illuminate\Routing\Route;
use SwaggerFromRoute\Parameter;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractRoute
{
	public function __construct(protected Route $route) {}

	public function toYaml()
	{
		return Yaml::dump($this->handle(), Yaml::PARSE_OBJECT_FOR_MAP);
	}

	public function securityType()
	{
		if (in_array('auth', $this->route->action['middleware'])) {
			return [
				'BasicAuth' => [
					'type' => 'http',
					'scheme' => 'basic',
				],
			];
		}

		if (in_array('auth:api', $this->route->action['middleware'])) {
			return [
				'BearerAuth' => [
					'type' => 'http',
					'scheme' => 'bearer',
				],
			];
		}

		if (in_array('apikey', $this->route->action['middleware'])) {
			return [
				'ApiKeyAuth' => [
					'type' => 'apiKey',
					'in' => 'header',
					'name' => 'X-API-Key',
				],
			];
		}

		return null;
	}

	public function parameters()
	{
		$ex = explode('/', $this->route->uri);

		$parameters = [];

		foreach($ex as $segment) {
			if (str($segment)->startsWith('{') && str($segment)->endsWith('}')) {
				$parameters[] = str($segment)->after('{')->before('}')->value;
			}
		}

		return $parameters;
	}

	public function yamlParameters()
	{
		$parameters = [];

		foreach($this->parameters() as $parameter) {
			$p = new Parameter($parameter);

			$parameters[] = $p->handle();

			unset($parameter, $p);
		}

		return $parameters;
	}

	abstract public function handle();
}