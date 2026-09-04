<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('investor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('entrepreneur_id')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'seen'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_invitations');
    }
};
