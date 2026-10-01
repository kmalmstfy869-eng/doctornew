<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();

            // null = حركة عيادة (إيراد/مصروف مش مرتبط بمريض)
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();

            $table->string('type', 10)->default('income'); // income | expense
            $table->string('title', 150);                  // الخدمة / البيان
            $table->decimal('amount', 10, 2);
            $table->date('paid_at');
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['doctor_id', 'paid_at']);
            $table->index(['doctor_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
