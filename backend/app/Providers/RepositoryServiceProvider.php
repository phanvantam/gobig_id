<?php
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
	
	public function register()
	{
		$this->app->bind('App\Repositories\AuthRepositoryInterface', 'App\Repositories\AuthRepository');
		$this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepository');
		$this->app->bind('App\Repositories\PermissionRepositoryInterface', 'App\Repositories\PermissionRepository');
	}
}