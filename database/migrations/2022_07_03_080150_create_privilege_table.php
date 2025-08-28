<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privilege', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('id_role');
            $table->string('id_menu');
            $table->tinyInteger('show_menu');
            $table->tinyInteger('create');
            $table->tinyInteger('read');
            $table->tinyInteger('show');
            $table->tinyInteger('update');
            $table->tinyInteger('delete');
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();
            $table->string('deleted_by', 36)->nullable();

            $table->foreign('id_role')->references('id')->on('role');
            $table->foreign('id_menu')->references('id')->on('menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privilege');
    }
};
