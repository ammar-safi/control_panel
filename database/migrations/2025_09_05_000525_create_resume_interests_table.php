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

        Schema::create('resume_interests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resume_id');
            $table->foreign('resume_id')->references('id')->on('resumes');
            $table->bigInteger('interested_in');
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
        Schema::dropIfExists('resume_interests');
    }
};
