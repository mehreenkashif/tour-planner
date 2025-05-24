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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tour title
            $table->text('description'); // Detailed description
            $table->date('start_date'); // Tour start date
            $table->date('end_date'); // Tour end date
            $table->foreignId('created_by')->constrained('users'); // Foreign key to users table
            $table->timestamps();




        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
