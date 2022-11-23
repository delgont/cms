<?php

namespace Delgont\Cms\Concerns;


trait RegistersPublishables
{
    private function registerPublishables() : void
    {
        //config file
        $this->publishes([
            __DIR__.'/../../config/delgont.php' => config_path('delgont.php')
        ], 'delgont-config');

        $this->publishes([
            __DIR__.'/../../config/web.php' => config_path('web.php')
        ], 'delgont-config-web');

        $this->publishes([
            __DIR__.'/../../config/data.sample.php' => config_path('data.php')
        ], 'delgont-config-data');


        // DB Migrations
        $this->publishes([
            __DIR__.'/../../database' => database_path(),
          ], 'delgont-database');
        
        // Overide where the user is redirected when not authenticated
        $this->publishes([
            __DIR__.'/../../stubs/middlewares/Authenticate.php.stub' => app_path('Http/Middleware/Authenticate.php'),
          ], 'delgont-overwrite-not-authenticated-redirect');

        // Overide where to redirect users if authenticated
        $this->publishes([
            __DIR__.'/../../stubs/middlewares/RedirectIfAuthenticated.php.stub' => app_path('Http/Middleware/RedirectIfAuthenticated.php'),
          ], 'delgont-overwrite-if-authenticated-redirect');
        
        // Overide User Model
        $this->publishes([
            __DIR__.'/../../stubs/Models/User.php.stub' => app_path('User.php'),
        ], 'delgont-overwrite-user-model');

    }
}