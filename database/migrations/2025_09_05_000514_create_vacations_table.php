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

        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ["emergency","maternity","hourly","daily","monthly"]);
            $table->enum('status', ["pending","approved","rejected"])->default('pending');
            $table->text('reject_reason')->nullable();
            $table->bigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('users');
            $table->bigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('users');
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
        Schema::dropIfExists('vacations');
    }
};
