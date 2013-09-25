<?php namespace Witooh\Entity;

use Illuminate\Support\ServiceProvider;

class EntityServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('Witooh\Entity\IAggregateFactory', function($app){
            return new AggregateFactory();
        });

        $this->app->singleton('Witooh\Entity\IEntityFactory', function($app){
            return new EntityFactory();
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}