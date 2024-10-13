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
        Schema::create('customs', function (Blueprint $table) {
            $table->id('custom_id');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('veggie')->default(0);
            $table->integer('chicken')->default(0);
            $table->integer('pork')->default(0);
            $table->integer('beef')->default(0);
            $table->boolean('icecream')->default(false);
            $table->boolean('frenchfries')->default(false);
            $table->boolean('mixedballs')->default(false);
            $table->boolean('hotdogs')->default(false);
            $table->boolean('cake')->default(false);
            $table->integer('lootbags')->default(0);
            $table->string('setup')->nullable();
            $table->integer('persons')->default(100);
            $table->decimal('final', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('package_id')->references('package_id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customs');
    }
};
