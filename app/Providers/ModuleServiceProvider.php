<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $modulepath = app_path('Modules');
        $modules = File::directories($modulepath);

        foreach ($modules as $module) {
            $routefile = $module . '/routes.php';
            // load routes
            if (file_exists($routefile)) {
                include $routefile;
            }

            // load views
            $viewdir = $module . '/Views';
            if (is_dir($viewdir)) {
                if (env('OS') == 'windows') {
                    $modulename = @end(explode("/", $module));
                } else {
                    $modulename = @end(explode("\\", $module));
                }
                $this->loadViewsFrom($viewdir, $modulename);
            }
        }
    }
}
