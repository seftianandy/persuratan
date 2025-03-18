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
        Schema::create('outcoming_mails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')
                ->nullable()
                ->constrained('senders')
                ->nullOnDelete();

            $table->foreignId('reciver_id')
                ->nullable()
                ->constrained('recivers')
                ->nullOnDelete();

            $table->string('reference_number')->unique();
            $table->longText('subject');
            $table->date('date');
            $table->date('implementation_date');
            $table->longText('description');
            $table->mediumText('file')
                ->charset('binary');
            $table->string('file_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outcoming_mails');
    }
};
