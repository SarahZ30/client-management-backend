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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // details entered by the user
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('company');
            $table->string('address');
            $table->integer('no_of_employees')->nullable();
            $table->double('project_budget');

            // values calculated by the system
            $table->double('service_charge')->nullable();
            $table->double('discount_value')->nullable();
            $table->double('final_project_value')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
