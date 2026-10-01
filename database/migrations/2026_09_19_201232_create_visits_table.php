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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();


            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();


            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->string('patient_name')->nullable();
            $table->string('patient_phone', 30)->nullable();
            // الشكوى الرئيسية
            $table->text('complaint')->nullable();

            // الأعراض
            $table->text('symptoms')->nullable();

            // التشخيص
            $table->text('diagnosis')->nullable();

            // العلاج والأدوية
            $table->json('treatment')->nullable();

            // التحاليل المطلوبة
            $table->text('required_tests')->nullable();

            // الأشعة المطلوبة
            $table->text('required_radiology')->nullable();

            // ملاحظات الطبيب
            $table->text('notes')->nullable();

            // موعد المتابعة
            $table->date('visit_date');
            $table->date('next_visit_date')->nullable();

            $table->timestamps();

            // تسريع البحث عن زيارات الطبيب والمريض
            $table->index(['doctor_id', 'patient_id']);

            // تسريع البحث حسب تاريخ الزيارة
            $table->index(['doctor_id', 'visit_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};

