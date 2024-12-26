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
        Schema::create('customitems', function (Blueprint $table) {
            $table->id('customitem_id');
            $table->unsignedBigInteger('custompackage_id');
            $table->string('item_name');
            $table->enum('item_type', ['food', 'beef', 'pork', 'chicken', 'veggie', 'others', 'dessert', 'food_pack', 'food_cart', 'lechon', 'cake', 'clown', 'facepaint', 'setup', 'service_fee'])->nullable();
            $table->decimal('item_price', 8, 2)->nullable();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('custompackage_id')->references('custompackage_id')->on('custompackages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customitems');
    }
};
