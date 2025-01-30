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
        Schema::create('file_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->constrained()->onDelete('cascade'); // Delete files if card is deleted
            $table->string('file_path'); // Path to stored file (e.g., 'attachments/abc123.pdf')
            $table->string('original_name'); // Original filename (e.g., 'lecture_notes.pdf')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_attachments');
    }
};
