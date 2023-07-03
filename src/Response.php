<?php
namespace SwaggerFromRoute;

class Response
{
	public function __construct(private $route) {}

	public function handle(bool $isError=false)
	{
		$data = [
			'schema' => [],
			'example' => [],
		];
		
		if ($isError) {
			unset($data['example']);

			$data['schema'] = [
				'mensagem' => [
					'type' => 'string',
				],
				'status' => [
					'type' => 'boolean',
				],
				'dados' => [
					'type' => 'array',
				],
				'erros' => [
					'type' => 'array',
				]
			];
		}

		return [
			'description' => '',
			'content' => [
				'application/json' => $data
			],
		];
	}
}