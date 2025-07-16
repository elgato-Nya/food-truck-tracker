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
        Schema::create('location_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_truck_id')->constrained()->onDelete('cascade');
            $table->string('reported_by')->default('Anonymous');
            $table->string('location_name')->nullable(); // User-friendly location name
            $table->text('location_description')->nullable(); // Additional description
            $table->decimal('latitude', 10, 8)->nullable(); // Will be populated after geocoding
            $table->decimal('longitude', 11, 8)->nullable(); // Will be populated after geocoding
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable(); // Notes from admin during review
            $table->timestamp('reviewed_at')->nullable();
            $table->string('reviewed_by')->nullable(); // Admin who reviewed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_reports');
    }
};
