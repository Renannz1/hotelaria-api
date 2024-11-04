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
        Schema::table('reserve', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('deilies', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('guests', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reserve', function (Blueprint $table) {
            //
        });
    }
};
