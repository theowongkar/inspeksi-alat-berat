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
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::create('equipment_type_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_type_id')->constrained('equipment_types')->onDelete('cascade');
            $table->string('category', 100);
        });

        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_type_id')->constrained('equipment_types')->onDelete('cascade');
            $table->string('machine_type', 100);
            $table->string('serial_number', 100);
            $table->string('make', 100);
            $table->string('model', 100);
            $table->year('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_types');
        Schema::dropIfExists('equipment_type_items');
        Schema::dropIfExists('equipments');
    }
};
