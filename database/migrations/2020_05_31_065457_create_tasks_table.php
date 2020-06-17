<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer( 'project_id' )->unsigned()->index();
            $table->integer( 'parent_id' )->default(0)->unsigned()->index();
            $table->integer( 'flow_process_id' )->unsigned()->index();
            $table->integer( 'sort_num' )->unsigned();
            $table->string( "name", "100" )->default('');
            $table->string( "description", "500" )->default('');
            $table->tinyInteger( "finished" )->default(0);
            $table->integer( 'creator_id' )->unsigned();
            $table->timestamp( "deadline" )->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
