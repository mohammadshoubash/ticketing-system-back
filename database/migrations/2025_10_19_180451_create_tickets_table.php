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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['voice', 'non-voice']);
            $table->string('priority');
            $table->text('comment')->nullable();
            $table->string('attachment')->nullable();
            $table->string('country');
            $table->string('language');
            $table->json('form_fields')->nullable(); // Store custom form fields as JSON
            $table->enum('status', ['Open', 'In Progress', 'Closed'])->default('Open');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
