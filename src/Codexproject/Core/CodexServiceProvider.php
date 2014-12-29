<?php
namespace Codexproject\Core;

use Illuminate\Support\ServiceProvider;

class CodexServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
		$this->package('codexproject/core', 'codex');

		// Include the routes file
		if ($this->app['config']->get('codex::use_routes') === true) {
			include __DIR__.'/../../routes.php';
		}

		$this->registerBindings();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// 
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('codex');
	}

	private function registerBindings()
	{
		$storageDriver = ucfirst($this->app['config']->get('codex::driver'));

		$this->app->bind('\Codexproject\Core\Repositories\CodexRepositoryInterface',
			'\Codexproject\Core\Repositories\CodexRepository'.$storageDriver);
	}
}
