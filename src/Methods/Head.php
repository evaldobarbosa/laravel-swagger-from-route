<?php
namespace SwaggerFromRoute\Methods;

class Head
{
	public function handle()
	{

// get:
//   summary: Buscar um cliente ou transportadora 
//   tags: 
//     - Cadastro
//   security:
//     - BearerAuth: []
//   parameters:
//     - in: path
//       name: id
//       description: id do cliente ou transportadora
//       required: true
//       schema:
//         type: string
//   responses: 
//     '200':
//       description: Success
//       content:
//         application/json:
		return [
			'head' => [
				'tags' => [],
				'security' => [],
				'parameters' => [
					'in' => [],
				]
			]
		];
	}
}