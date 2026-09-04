<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->year('year_founded')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->text('target_audience')->nullable();
            $table->longText('business_plan')->nullable();
            $table->enum('sale_type', ['individual', 'complete'])->default('individual');
            $table->decimal('percentage_available', 5, 2)->default(0);
            $table->decimal('price_per_share', 15, 2)->nullable();
            $table->integer('total_shares')->nullable();
            $table->decimal('company_value', 15, 2)->nullable();
            $table->decimal('minimum_investment', 15, 2)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
