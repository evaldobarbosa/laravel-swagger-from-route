<?php
namespace SwaggerFromRoute\Methods;

use SwaggerFromRoute\Response;
use Symfony\Component\Yaml\Yaml;

class Input extends AbstractRoute
{
	public function handle()
	{
		$route = [
			'get' => [
				'tags' => [],
				'parameters' => $this->yamlParameters(),
				'requestBody' => [
					'required' => true,
					'content' => [
						'application/json' => [
							'schema' => [],
							'example' => [],
						]
					]
				]
			]
		];

		$securityType = $this->securityType();
		if (!is_null($securityType)) {
			$route['security'] = $securityType;
		}
		unset($securityType);

		$route['responses'] = [
			'200' => (new Response($this->route))->handle(),
			'201' => (new Response($this->route))->handle(),
			'401' => (new Response($this->route))->handle(true),
			'403' => (new Response($this->route))->handle(true),
			'500' => (new Response($this->route))->handle(true),
		];

		return $route;
	}
}