<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use DB;

class DBTimestamp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:timestamp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate timestamp column';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $q = DB::select("select * from information_schema.COLUMNS where TABLE_SCHEMA='".env('DB_DATABASE')."'");
        $data = [];
        foreach($q as $row)
        {
            $data[$row->TABLE_NAME][] = $row->COLUMN_NAME;   
        }
        
        foreach($data as $tbl => $arr)
        {
            if(!in_array("created_at",$arr))
            {
                $this->comment('Adding timestamps on table '.$tbl);
                Schema::table($tbl, function (Blueprint $table) {
                    $table->timestamps();
                    $table->softdeletes();
                    $table->string('created_by', 36)->nullable();
                    $table->string('updated_by', 36)->nullable();
                    $table->string('deleted_by', 36)->nullable();
                });
            }
        }
    }
}
