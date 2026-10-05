<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('critique_updates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('critique_id')
                ->constrained('critiques')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('old_status')->nullable();
            $table->string('new_status');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('critique_updates');
    }
};
