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
        Schema::table('example_outcoming_mails', function (Blueprint $table) {
            $table->mediumText('file')->nullable()->charset('binary')->change(); // Tambahkan nullable
            $table->string('file_type')->nullable()->change(); // Tambahkan nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('example_outcoming_mails', function (Blueprint $table) {
            $table->mediumText('file')->charset('binary')->change(); // Kembalikan ke non-nullable
            $table->string('file_type')->change(); // Kembalikan ke non-nullable
        });
    }
};
