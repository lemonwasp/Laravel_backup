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
        Schema::create('bookdetails', function (Blueprint $table) {
            $table->foreignId('book_id')
            ->constrained('books')
            ->onDelete('cascade')
            ->primary();
            $table->string('isbn','20')->unique();
            $table->date('published_date');
            $table->integer('price')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookdetails');
    }
};
