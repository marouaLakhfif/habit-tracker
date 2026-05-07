<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->integer('target_days')->nullable()->comment('How many days to achieve');
            $table->date('end_date')->nullable()->comment('Target completion date');
            $table->string('goal_type')->default('unlimited')->comment('unlimited, days, date');
        });
    }

    public function down()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn(['target_days', 'end_date', 'goal_type']);
        });
    }
};