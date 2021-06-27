<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAgentSupervisorMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_agent_supervisor_mappings', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id');
            $table->integer('supervisor_id');
            $table->integer('mapping_by');
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
        Schema::dropIfExists('tbl_agent_supervisor_mappings');
    }
}
