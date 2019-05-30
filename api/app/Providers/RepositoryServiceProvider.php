<?php
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
	
	public function register()
	{
		$this->app->bind('App\Repositories\ScriptRepositoryInterface', 'App\Repositories\ScriptRepository');
		$this->app->bind('App\Repositories\BlockRepositoryInterface', 'App\Repositories\BlockRepository');
		$this->app->bind('App\Repositories\WebhookRepositoryInterface', 'App\Repositories\WebhookRepository');
		$this->app->bind('App\Repositories\FacebookRepositoryInterface', 'App\Repositories\FacebookRepository');
		$this->app->bind('App\Repositories\FanpageRepositoryInterface', 'App\Repositories\FanpageRepository');
		$this->app->bind('App\Repositories\FanpageScriptRepositoryInterface', 'App\Repositories\FanpageScriptRepository');
		$this->app->bind('App\Repositories\CustomerRepositoryInterface', 'App\Repositories\CustomerRepository');
		$this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepository');
		$this->app->bind('App\Repositories\ScriptProcessRepositoryInterface', 'App\Repositories\ScriptProcessRepository');
		$this->app->bind('App\Repositories\FormDataRepositoryInterface', 'App\Repositories\FormDataRepository');

	}
}