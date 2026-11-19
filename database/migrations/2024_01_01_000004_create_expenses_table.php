<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('amount');
            $table->date('expense_date');
            $table->enum('category', ['ATK', 'Kebersihan', 'Sosial', 'Acara', 'Lainnya'])->default('Lainnya');
            $table->text('note')->nullable();
            $table->string('receipt_image')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
