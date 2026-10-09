<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // آخر خطأ حصل وقت نسخ الملف ووقت آخر محاولة، عشان الأدمن يعرف الملف الفاشل بالاسم. بيتمسح لما النسخ ينجح.
        Schema::table('patient_files', function (Blueprint $table) {
            $table->string('backup_last_error', 255)->nullable()->after('size');
            $table->timestamp('backup_attempted_at')->nullable()->after('backup_last_error');
        });
    }

    public function down(): void
    {
        Schema::table('patient_files', function (Blueprint $table) {
            $table->dropColumn(['backup_last_error', 'backup_attempted_at']);
        });
    }
};
