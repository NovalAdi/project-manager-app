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
        Schema::create('notifs', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->foreignId('invitation_id')->nullable()->constrained('invitations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('task_id')->nullable()->constrained('tasks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('from')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('to')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type', ['invitation', 'task_return']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifs');
    }
};
