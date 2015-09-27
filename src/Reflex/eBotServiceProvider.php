<?php

namespace Reflex;

use Illuminate\Support\ServiceProvider;

class eBotServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 *
	 * @return  void
	 */
	public function boot()
	{
		// Publish the config file
		$this->publishes([
			__DIR__.'/../config/config.php' => config_path('ebot-reflex.php'),
		]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return  void
	 */
	public function register()
	{
		
	}
}