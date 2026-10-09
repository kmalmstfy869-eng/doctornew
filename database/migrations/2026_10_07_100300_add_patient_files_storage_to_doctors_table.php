<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // عمودين في جدول الأطباء: المساحة المسموحة للطبيب، والمساحة المتبقية له (بالـ GB). الافتراضي 25 لكل طبيب.
        Schema::table('doctors', function (Blueprint $table) {
            $table->decimal('patient_files_quota_gb', 10, 3)->default(25)->after('status');
            $table->decimal('patient_files_remaining_gb', 10, 3)->default(25)->after('patient_files_quota_gb');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['patient_files_quota_gb', 'patient_files_remaining_gb']);
        });
    }
};
