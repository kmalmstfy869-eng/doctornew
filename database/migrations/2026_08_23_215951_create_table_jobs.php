<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->string('company_name');

            $table->string('phone');

            $table->string('whatsapp');

            $table->string('category');

            $table->string('qualification');

            $table->string('location')
                ->nullable();

            $table->enum('job_type', [
                'دوام كامل',
                'دوام جزئي',
                'العمل عن بعد',
            ]);

            $table->enum('experience', [
                'أقل من سنة',
                'من سنة إلى 3 سنوات',
                'من 3 إلى 5 سنوات',
                'أكثر من 5 سنوات',
            ]);

            $table->decimal('salary_min', 10, 2)
                ->nullable();

            $table->decimal('salary_max', 10, 2)
                ->nullable();

            $table->text('description');

            $table->unsignedInteger('vacancies')
                ->default(1);

            $table->string('working_hours')
                ->nullable();

            $table->string('working_days')
                ->nullable();

            $table->date('application_deadline');


            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

