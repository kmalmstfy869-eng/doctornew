<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Doctor
            |--------------------------------------------------------------------------
            |
            | صاحب ملف المريض داخل العيادة
            |
            */

            $table->foreignId('doctor_id')
                ->constrained('doctors')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Patient Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('phone')->nullable();


            $table->date('birth_date')->nullable();

            $table->enum('gender', [
                'male',
                'female',
            ])->nullable();

            $table->text('address')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->index([
                'doctor_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
