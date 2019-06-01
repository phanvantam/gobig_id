<?php
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
	
	public function register()
	{
		$this->app->bind('App\Repositories\TypeRepositoryInterface', 'App\Repositories\TypeRepository');
		$this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepository');
	}
}