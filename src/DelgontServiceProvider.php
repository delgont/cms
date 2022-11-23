<?php

namespace Delgont\Cms;

use Illuminate\Support\ServiceProvider;

use Illuminate\Routing\Router;
use Delgont\Cms\Concerns\RegistersCommands;
use Delgont\Cms\Concerns\BootObservers;
use Delgont\Cms\Concerns\RegistersPublishables;



/**
 * Middleware
 */
use Delgont\Cms\Http\Middleware\Permission\Permission;
use Delgont\Cms\Http\Middleware\Permission\PermissionViaRole;
use Delgont\Cms\Http\Middleware\Permission\PermissionOrRole;




use Illuminate\Database\Eloquent\Relations\Relation;



class DelgontServiceProvider extends ServiceProvider
{
    use RegistersCommands, RegistersPublishables, BootObservers;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $helpers = glob( __DIR__.'/Helpers'.'/*.php');

        foreach($helpers as $key => $helper){
            require_once($helper);
        }

        $this->registerCommands();

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('permission', Permission::class);
        $router->aliasMiddleware('permissionViaRole', PermissionViaRole::class);
        $router->aliasMiddleware('permissionOrRole', PermissionOrRole::class);


        if ($this->app->runningInConsole()) {
            $this->registerPublishables();
            $this->registerCommands();
        }

        $this->bootObservers();

       
        
    }

   

  
}
