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
        Schema::create('packages', function (Blueprint $table) {
            $table->id('package_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('packagename')->unique()->nullable();
            $table->string('packagedesc')->nullable();
            $table->decimal('discountedprice', 8, 2)->nullable();
            $table->text('packageinclusion')->nullable();
            $table->string('packagephoto')->nullable();
            $table->string('packagetype')->nullable();
            $table->string('packagestatus')->default('active');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
