<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_schedules', function (Blueprint $table) {

            $table->id();

            $table->foreignId('doctor_id')
                ->constrained('doctors')
                ->cascadeOnDelete();

            // 0 = الأحد
            // 1 = الإثنين
            // 2 = الثلاثاء
            // 3 = الأربعاء
            // 4 = الخميس
            // 5 = الجمعة
            // 6 = السبت
            $table->unsignedTinyInteger('day_of_week');

            $table->time('start_time');

            $table->time('end_time');

            // مدة الحجز بالدقائق
            $table->unsignedInteger('slot_duration')->default(30);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // يوم واحد فقط لكل طبيب
            $table->unique([
                'doctor_id',
                'day_of_week',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_schedules');
    }
};
