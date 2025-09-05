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
        Schema::disableForeignKeyConstraints();

        Schema::create('resume_education', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resume_id');
            $table->foreign('resume_id')->references('id')->on('resumes');
            $table->string('institution_name');
            $table->enum('degree', ["Bachelors","Master","phd"])->nullable()->default('Bachelors');
            $table->string('Specialization')->nullable();
            $table->date('start_year');
            $table->date('end_year')->nullable();
            $table->string('gpa')->nullable();
            $table->string('location')->nullable();
            $table->softDelete();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_education');
    }
};
