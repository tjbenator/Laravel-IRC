<?php namespace Tjbenator\Irc;

use Illuminate\Support\ServiceProvider;

class IrcServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('tjbenator/irc', 'tjbenator/irc');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app['irc'] = $this->app->share(function($app)
		{
			return new \Tjbenator\Irc\Irc;
		});

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Irc', 'Tjbenator\Irc\Facades\Irc');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('irc');
	}

}
