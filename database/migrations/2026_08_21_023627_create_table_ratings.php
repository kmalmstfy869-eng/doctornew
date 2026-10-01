<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('doctor_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('rating')->check('rating >= 1 AND rating <= 5');

           $table->string('comment', 400);
            $table->boolean('is_read')->default(false);

            $table->timestamps();

            $table->unique(['user_id', 'doctor_id']);
            $table->enum('status', [
                                        'approved',
                                        'rejected',
                     ])->default('approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
