<?php

namespace SwaggerFromRoute\Providers;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{

	public function register(): void
	{
		//
	}


	public function boot(): void
	{
		$this->mergeConfigFrom(
			__DIR__.'/../../config/sfroute.php', 'sfroute'
    );

    $this->publishes([
        __DIR__.'/../../config/sfroute.php' => config_path('sfroute.php'),
    ]);
	}
}
