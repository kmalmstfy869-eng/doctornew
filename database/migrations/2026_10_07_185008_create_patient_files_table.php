<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول لحفظ بيانات ملفات المرضى، بينما الملف نفسه يتم حفظه في Storage.
        Schema::create('patient_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('original_name');
            // مفتاح الملف في الـ Storage (UUID). مفيش overwrite أبدًا، فالمفتاح بيمثل نسخة واحدة ثابتة.
            $table->string('stored_path')->unique();
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->timestamps();

            // indexes لحساب المساحة وقائمة الملفات والبحث بالمريض من غير بطء.
            $table->index(['doctor_id', 'created_at']);
            $table->index(['doctor_id', 'patient_id', 'created_at']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_files');
    }
};
