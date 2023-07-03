<?php
namespace SwaggerFromRoute;

class Parameter
{
	private $required = true;
	private $name;

	public function __construct(string $name) {
		if (str($name)->endsWith('?')) {
			$this->required = false;
		}

		$this->name = str($name)->before('?')->value;
	}

	public function handle()
	{
		return [
			'in' => 'path',
			'name' => $this->name,
			'description' => '',
			'required' => $this->required,
			'schema'=> [
				'type' => 'string',
			]
		];
	}
}