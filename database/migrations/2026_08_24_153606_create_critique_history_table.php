<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('critique_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('critique_id');
            $table->enum('old_status', ['dikirim', 'ditinjau', 'diproses', 'selesai', 'ditolak'])->nullable();
            $table->enum('new_status', ['dikirim', 'ditinjau', 'diproses', 'selesai', 'ditolak']);
            $table->unsignedBigInteger('changed_by');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('critique_id')->references('id')->on('critiques')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('critique_histories');
    }
};
