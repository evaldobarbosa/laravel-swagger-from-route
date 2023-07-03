<?php
namespace SwaggerFromRoute;

use Symfony\Component\Yaml\Yaml;

class FileGenerator
{
	public function __construct(private RouteManager $routeManager)
	{}

	public function handle()
	{
		$routeFiles = [];

		foreach($this->routeManager->validRoutes() as $route) {
			$routeFiles = array_merge(
				$routeFiles,
				$this->makeRouteFile($route)
			);
			echo "<p>$route->uri: " . current($route->methods) . " criado.</p>";
		}

		$this->makeApiFile($routeFiles);
	}

	private function makeRouteFile($route)
	{
		$routeFile = new RouteFile($route);

		if ($routeFile->exists()) {
			if (!$routeFile->isEmpty()) {
				throw new \Exception(
					"Arquivo de rota já existe $routeFile->filename ($routeFile->verb)",
					1
				);
			}
		}

		$routeFile->write();

		return [
			$route->uri => [
				'$ref' => sprintf('./%s', $routeFile->getFullPath()),
			]
		];
	}

	private function makeApiFile(array $routes)
	{
		$content = [
			'openapi' => '3.0.0',
			'info' => '',
			'title' => config('sfroute.title'),
			'description' => config('sfroute.description'),
			'version' => config('sfroute.version'),
			'paths' => $routes,
			'jlahsd' => 'asdasd',
		];
		
		\Storage::disk('sfr')->put("api.yml", Yaml::dump($content, Yaml::DUMP_OBJECT_AS_MAP));
	}
}