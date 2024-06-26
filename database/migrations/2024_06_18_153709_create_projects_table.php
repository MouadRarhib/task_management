<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id('pkid_project');
            $table->string('name', 128);
            $table->date('created_date');
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('fkid_task')->nullable();
            $table->foreign('fkid_task')->references('pkid_task')->on('tasks')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
