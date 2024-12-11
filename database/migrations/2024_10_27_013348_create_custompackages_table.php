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
        Schema::create('custompackages', function (Blueprint $table) {
            $table->id('custompackage_id');
            $table->unsignedBigInteger('package_id');
            $table->decimal('final_price', 8, 2)->nullable();
            $table->string('person')->nullable();
            $table->string('target')->nullable();
            $table->timestamps();

            $table->foreign('package_id')->references('package_id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custompackages');
    }
};
