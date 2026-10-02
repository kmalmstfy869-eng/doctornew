<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visit_stats', function (Blueprint $table) {
            $table->id();
            $table->string('page_type', 32);                      // home | doctor_profile
            $table->unsignedBigInteger('doctor_id')->default(0);  // 0 = مش خاص بدكتور (الهوم)
            $table->date('stat_date');
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('unique_visitors')->default(0);
            $table->timestamps();

            $table->unique(['page_type', 'doctor_id', 'stat_date']);
            $table->index('stat_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_visit_stats');
    }
};
