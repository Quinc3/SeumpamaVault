<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_type_id')->constrained()->cascadeOnDelete();
            $table->string('transaction_code')->unique();
            $table->date('transaction_date');
            $table->decimal('total_budget', 15, 2)->default(0);
            $table->decimal('total_realization', 15, 2)->default(0);
            $table->string('evidence_file')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
