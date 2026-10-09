<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // سجل نتيجة كل تشغيل للـ Backup: آخر نجاح، عدد المنسوخ والفاشل، الحجم، البداية والنهاية.
        Schema::create('patient_file_backup_runs', function (Blueprint $table) {
            $table->id();
            $table->string('status', 20)->index(); // running | success | partial | failed
            $table->unsignedInteger('copied_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->unsignedInteger('purged_count')->default(0);
            $table->unsignedBigInteger('copied_bytes')->default(0);
            $table->text('error')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_file_backup_runs');
    }
};
