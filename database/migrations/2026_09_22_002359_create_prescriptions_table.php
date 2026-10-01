<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_id')
                ->constrained('doctors')
                ->cascadeOnDelete();

            // nullable: الروشتة ممكن تتعمل لشخص غير مسجل عند الدكتور
            $table->foreignId('patient_id')
                ->nullable()
                ->constrained('patients')
                ->nullOnDelete();

            // snapshot لاسم ورقم المريض وقت إنشاء الروشتة (مهم للشخص غير المسجل)
            $table->string('patient_name')->nullable();
            $table->string('patient_phone', 30)->nullable();

            $table->date('prescription_date');
            $table->date('next_visit_date')->nullable();

            // [{name, dose, frequency, duration, timing, notes}, ...]
            $table->json('medications');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['doctor_id', 'prescription_date']);
            $table->index(['doctor_id', 'patient_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
