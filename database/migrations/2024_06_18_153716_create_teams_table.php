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
        Schema::create('teams', function (Blueprint $table) {
            $table->id('pkid_team');
            $table->string('name', 128);
            $table->unsignedBigInteger('fkid_project')->nullable();
            $table->foreign('fkid_project')->references('pkid_project')->on('projects')->onDelete('set null');
            $table->unsignedBigInteger('fkid_user')->nullable();
            $table->foreign('fkid_user')->references('pkid_user')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teams');
    }
};
