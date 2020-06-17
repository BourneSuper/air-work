<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlowProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow_processes', function (Blueprint $table) {
            $table->id();
            $table->integer( 'project_id' )->unsigned()->index();
            $table->integer( 'flow_id' )->unsigned()->index();
//             $table->integer( 'prev_flow_process_id' )->default(-1)->index();
//             $table->integer( 'next_flow_process_id' )->default(-1)->index();
            $table->integer( 'sort_num' )->unsigned();
            $table->string( "name", "100" )->default('');
            $table->string( "description", "100" )->default('');
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
        Schema::dropIfExists('flow_processes');
    }
}
