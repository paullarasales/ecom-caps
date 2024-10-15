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
        Schema::table('customs', function (Blueprint $table) {
            $table->integer('fish')->default(0)->after('chicken');
            $table->integer('lechon')->default(0)->after('veggie');
            $table->integer('foodpack')->default(0)->after('pork');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customs', function (Blueprint $table) {
            $table->dropColumn('fish');
            $table->dropColumn('foodpack');
            $table->dropColumn('lechon');
        });
    }
};
