<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Debugger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:me';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $modulepath = app_path('Modules');
        $modules = File::directories($modulepath);

        foreach($modules as $module){
            $routefile = $module.'/routes.php';
            // load routes
            if(file_exists($routefile)){
                echo $routefile."\n";
                // include $routefile;
            }

            // load views
            if(is_dir($module.'/Views')){
                echo @end(explode("/", $module));
                // echo $module.'/Views --- '. $module."\n";
                // $this->loadViewsFrom($module.'/Views', $module);
            }
        }
    }
}
