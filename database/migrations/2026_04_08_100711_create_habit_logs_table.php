<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')->constrained()->onDelete('cascade');
            $table->date('log_date');
            $table->boolean('completed')->default(false);
            $table->timestamps();
            
            $table->unique(['habit_id', 'log_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('habit_logs');
    }
};