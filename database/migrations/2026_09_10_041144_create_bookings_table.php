<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Doctor
            |--------------------------------------------------------------------------
            */

            $table->foreignId('doctor_id')
                ->constrained('doctors')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Patient
            |--------------------------------------------------------------------------
            */

            $table->foreignId('patient_id')
                ->nullable()
                ->constrained('patients')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Patient Information
            |--------------------------------------------------------------------------
            */

            $table->string('patient_name');

            $table->string('patient_phone')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Booking Type
            |--------------------------------------------------------------------------
            |
            | online = حجز من موقع دليل الأطباء
            | clinic = حجز من داخل العيادة
            |
            */

            $table->enum('booking_type', [
                'online',
                'clinic',
            ])->default('online');


            /*
            |--------------------------------------------------------------------------
            | Appointment
            |--------------------------------------------------------------------------
            */

            $table->date('appointment_date');

            $table->time('start_time')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Booking Status
            |--------------------------------------------------------------------------
            |
            | pending     = حجز قائم / في الانتظار
            | in_progress = المريض داخل الكشف
            | completed   = انتهى الكشف
            | cancelled   = تم إلغاء الحجز
            | no_show     = المريض لم يحضر
            |
            */

            $table->enum('status', [
                'pending',
                'in_progress',
                'completed',
                'cancelled',
                'no_show',
                'confirmed',
            ])->default('pending');


            /*
            |--------------------------------------------------------------------------
            | Price & Payment
            |--------------------------------------------------------------------------
            */

            $table->decimal('price', 10, 2)
                ->nullable();

            $table->decimal('paid', 10, 2)
                ->default(0);

            $table->decimal('paid_amount', 10, 2)
                ->default(0);






           $table->string('service', 100)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Arrival & Visit Times
            |--------------------------------------------------------------------------
            */

            $table->timestamp('arrived_at')
                ->nullable();

            $table->timestamp('called_at')
                ->nullable();

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            |
            | أهم الاستعلامات ستكون حسب الدكتور + التاريخ
            | وحالة الحجز.
            |
            */

            $table->index([
                'doctor_id',
                'appointment_date',
            ]);

            $table->index([
                'doctor_id',
                'appointment_date',
                'status',
            ]);


            $table->index([
                'patient_id',
                'appointment_date',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Appointment
            |--------------------------------------------------------------------------
            |
            | نفس الدكتور لا يمكن أن يكون لديه حجزان
            | في نفس اليوم ونفس وقت البداية.
            |
            */

            $table->unique([
                'doctor_id',
                'appointment_date',
                'start_time',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
