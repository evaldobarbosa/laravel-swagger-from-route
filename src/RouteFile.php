<?php
namespace SwaggerFromRoute;

use Illuminate\Routing\Route;
use Symfony\Component\Yaml\Yaml;

class RouteFile
{
	private $filename;
	private $path;
	private $verb;

	public function __construct(private Route $route)
	{
		$this->verb = current($route->methods);

		$ex = explode( "/", preg_replace("/[^0-9a-zA-Z_\/\.\-]/", "", $route->uri) );

		$this->setFilename( array_pop($ex) );

		$this->path = implode("/", $ex);

		unset($ex);
	}

	private function setFilename($filename)
	{
		// $this->filename = preg_replace("/[^0-9a-zA-Z_\/\.\-]/", "", $filename) . '.yml';
		$this->filename = $filename . '.yml';

		return $this;
	}

	private function getFullFilename()
	{
		return $this->verb . '_' . $this->filename;
	}

	public function getFullPath()
	{
		return sprintf(
			"%s/%s/%s_%s",
			'swaggerApi',
			$this->path,
			$this->verb,
			$this->filename
		);
	}

	public function write()
	{
		$content = (in_array('GET', $this->route->methods))
		? new \SwaggerFromRoute\Methods\Get($this->route)
		: new \SwaggerFromRoute\Methods\Input($this->route);

		\Storage::disk('sfr')->put($this->getFullPath(), $content->toYaml());
	}

	public function exists()
	{
		return \Storage::disk('sfr')->exists($this->getFullPath());
	}

	public function isEmpty()
	{
		$content = \Storage::disk('sfr')->get($this->getFullPath());

		if (is_null($content)) {
			return true;
		}

		if ($content == 'null') {
			return true;
		}

		return false;
	}

	public function __get($key)
	{
		switch($key)
		{
			case 'filename':
				return $this->filename;
			case 'verb':
				return $this->verb;
			case 'path':
				return $this->path;
		}
	}
}