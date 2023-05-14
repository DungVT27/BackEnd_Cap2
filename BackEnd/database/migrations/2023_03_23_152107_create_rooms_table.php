<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('room_owner');
            
            $table->string('name', 100);
            $table->string('description', 200)->nullable();
            $table->string('image', 2048);
            $table->timestamps();

            $table->foreign('room_owner')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
                  
             
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
