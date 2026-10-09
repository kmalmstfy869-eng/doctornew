<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_messages', function (Blueprint $table) {
            $table->id();

            // لو الدكتور أو الحجز اتمسح، الرسائل بتاعته تتمسح معاه
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();

            // لو اليوزر اتمسح الرسالة تفضل، بس من غير اسمه
            $table->foreignId('sender_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('resolved_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            // مين اللي المفروض يشوف الرسالة: doctor | assistant
            $table->string('recipient_role', 20);

            // doctor_call_patient | assistant_patient_missing
            $table->string('type', 40);

            // active | resolved | deleted
            $table->string('status', 20)->default('active');

            $table->string('patient_name');
            $table->string('message');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['doctor_id', 'recipient_role', 'status', 'id'], 'clinic_messages_inbox_idx');
            $table->index(['booking_id', 'type', 'status'], 'clinic_messages_dupe_idx');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_messages');
    }
};