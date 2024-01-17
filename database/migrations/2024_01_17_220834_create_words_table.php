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
        Schema::create('words', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('book_id');
            $table->foreign('book_id')->references('id')->on('books')->cascadeOnDelete();
            $table->string('english');
            $table->string('japanese');
            $table->longText('memo');
            $table->integer('isUnderstood')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
