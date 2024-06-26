<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('pkid_task');
            $table->string('name', 128);
            $table->string('description', 1024)->nullable();
            $table->unsignedBigInteger('fkid_status');
            $table->foreign('fkid_status')->references('pkid_status')->on('statuses')->onDelete('cascade');
            $table->timestamps(); // Adds 'created_at' and 'updated_at'
            $table->softDeletes(); // Adds 'deleted_at' for soft deletes
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
