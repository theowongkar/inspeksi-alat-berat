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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
            $table->foreignId('inspector_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('equipment_type_id')->constrained('equipment_types')->onDelete('cascade');
            $table->date('inspection_date');
            $table->string('location', 255);
            $table->timestamps();
        });

        Schema::create('inspection_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained('inspections')->onDelete('cascade');
            $table->string('report_no', 100)->nullable();
            $table->integer('hour_reading')->nullable();
            $table->string('state_id', 100)->nullable();
            $table->string('capacity', 50)->nullable();
        });

        Schema::create('inspection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained('inspections')->onDelete('cascade');
            $table->foreignId('equipment_type_item_id')->constrained('equipment_type_items')->onDelete('cascade');
            $table->integer('score');
            $table->text('description');
        });

        Schema::create('inspection_problems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained('inspections')->onDelete('cascade');
            $table->text('notes');
        });

        Schema::create('inspection_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_problem_id')->constrained('inspection_problems')->onDelete('cascade');
            $table->string('photo_url', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
        Schema::dropIfExists('inspection_infos');
        Schema::dropIfExists('inspection_items');
        Schema::dropIfExists('inspection_problems');
        Schema::dropIfExists('inspection_photos');
    }
};
