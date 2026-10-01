<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {

            $table->id()->index();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('area_id')
                ->constrained('areas')
                ->restrictOnDelete();

            $table->foreignId('specialty_id')
                ->constrained('specialties')
                ->restrictOnDelete();

            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('experience');

            $table->decimal('consultation_price', 10, 2);

            $table->string('clinic_name')->nullable();

            $table->text('address')->nullable();

            $table->string('google_maps_url')->nullable();

            $table->text('working_hours')->nullable();




            $table->text('bio')->nullable();
            $table->enum('status', [
                                'pending',
                                'approved',
                                'rejected',
                     ])->default('pending');
            $table->json('services')->nullable();

            $table->string('doctor_image')->nullable();

            $table->json('clinic_images')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
