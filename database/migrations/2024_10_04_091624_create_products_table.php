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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->integer('price');
            $table->string('image_source',100);
            $table->string('theme',30);
            $table->string('language',30);
            $table->string('author',100);
            $table->string('publisher',100);
            $table->date('published_date');
            $table->string('introduction',2000);
            $table->integer('stock');
            $table->date('launched_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
