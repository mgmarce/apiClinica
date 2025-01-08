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
        Schema::table('users', function (Blueprint $table) {
            //agregando columna
            $table->unsignedBigInteger('rol_id')->after('id');
            $table->foreign('rol_id')->references('id')->on('rol')->onDelete('cascade');
            //$table->foreignId('rol_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //eliminando columnas
            $table->dropForeign(['rol_id']);
            $table->dropColumn('rol_id');
        });
    }
};
