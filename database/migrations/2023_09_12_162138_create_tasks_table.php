<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['todo', 'done']);
            $table->tinyInteger('priority');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->foreignId('parent_id')->nullable()->references('id')->on('tasks');
            $table->foreignId('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
