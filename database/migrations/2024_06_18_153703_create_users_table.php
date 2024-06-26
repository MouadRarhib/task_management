<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('pkid_user');
            $table->string('full_name', 128);
            $table->string('role', 64);
            $table->string('email', 128)->unique();
            $table->string('password', 256);
            $table->unsignedBigInteger('fkid_task')->nullable();
            $table->foreign('fkid_task')->references('pkid_task')->on('tasks')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
