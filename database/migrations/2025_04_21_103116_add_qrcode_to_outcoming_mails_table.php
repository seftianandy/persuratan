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
        Schema::table('outcoming_mails', function (Blueprint $table) {
            $table->mediumText('qrcode')
                ->charset('binary')
                ->nullable()
                ->after('file_type');
        });
    }

    public function down(): void
    {
        Schema::table('outcoming_mails', function (Blueprint $table) {
            $table->dropColumn('qrcode');
        });
    }

};
