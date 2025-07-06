<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_trucks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('food_type');
            $table->string('location_description');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('menu_info')->nullable();
            $table->text('news')->nullable();
            $table->string('reported_by')->default('Admin');
            $table->timestamp('last_reported_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_trucks');
    }
};
