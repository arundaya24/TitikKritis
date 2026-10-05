<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('critique_update_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('critique_update_id')
                ->constrained('critique_updates')
                ->cascadeOnDelete();

            $table->string('file_path');
            $table->string('original_name');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('critique_update_files');
    }
};
