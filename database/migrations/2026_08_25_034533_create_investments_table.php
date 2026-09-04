<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->decimal('percentage_acquired', 5, 2)->default(0);
            $table->decimal('amount_invested', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
