<?php
namespace SwaggerFromRoute\Methods;

use SwaggerFromRoute\Response;
use SwaggerFromRoute\Parameter;
use Symfony\Component\Yaml\Yaml;

class Get extends AbstractRoute
{
	public function handle()
	{
		$route = [
			'get' => [
				'tags' => [],
				'parameters' => $this->yamlParameters(),
				'responses' => [
					'200' => (new Response($this->route))->handle(),
					'401' => (new Response($this->route))->handle(true),
					'403' => (new Response($this->route))->handle(true),
					'500' => (new Response($this->route))->handle(true),
				]
			]
		];

		$securityType = $this->securityType();
		if (!is_null($securityType)) {
			$route['security'] = $securityType;
		}
		unset($securityType);

		return $route;
	}
}