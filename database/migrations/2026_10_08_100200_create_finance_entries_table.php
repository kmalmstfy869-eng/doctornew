<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // دفتر المالية: كل حركة داخلة (income) أو خارجة (expense).
        Schema::create('finance_entries', function (Blueprint $table) {
            $table->id();
            $table->string('type', 10);
            $table->string('category', 40);
            $table->string('title', 150);
            $table->decimal('amount', 12, 2);
            $table->date('entry_date');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index(['type', 'entry_date']);
            $table->index('entry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_entries');
    }
};
