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

        Schema::create('resume_projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resume_experiences_id');
            $table->foreign('resume_experiences_id')->references('id')->on('resume_experiences');
            $table->longText('project');
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
        Schema::dropIfExists('resume_projects');
    }
};
