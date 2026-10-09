<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('storage_subscriptions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('doctor_id')->unique()->constrained()->cascadeOnDelete();
            $t->string('period', 10);                    // monthly | yearly
            $t->unsignedSmallInteger('units')->default(1);
            $t->decimal('gb', 8, 3);                     // المساحة الإضافية (snapshot)
            $t->date('start_date');
            $t->date('end_date');
            $t->string('status', 10)->default('active'); // active | expired
            $t->decimal('locked_price', 10, 2);          // السعر الثابت للفترة
            $t->timestamps();
            $t->index(['status', 'end_date']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('storage_subscriptions');
    }
};
