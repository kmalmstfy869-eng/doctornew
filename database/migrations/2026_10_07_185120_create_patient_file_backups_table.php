<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول بيتتبع اللي اتنسخ للـ Backup. من غير Foreign Keys عن قصد، عشان حذف الملف أو المريض ما يمسحش سجل الـ Backup.
        Schema::create('patient_file_backups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_file_id')->nullable()->index();
            $table->unsignedBigInteger('doctor_id')->index();
            $table->unsignedBigInteger('patient_id')->index();
            $table->string('original_name');
            $table->string('source_path')->unique();
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->timestamp('backed_up_at');
            // وقت حذف الملف من الـ Primary. بيبدأ منه عدّاد الـ 30 يوم.
            $table->timestamp('source_deleted_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_file_backups');
    }
};
