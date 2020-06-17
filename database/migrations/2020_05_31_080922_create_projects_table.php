<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer( 'flow_id' )->default( 0 )->unsigned()->index();
            $table->integer( 'owner_id' )->unsigned()->index();
            $table->string( 'owner_name', 100 );
            $table->string( "name", "100" );
            $table->string( "description", "500" );
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
        Schema::dropIfExists('projects');
    }
}
