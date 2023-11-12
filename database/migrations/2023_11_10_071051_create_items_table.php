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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('entity_id');
            $table->string('category_name');
            $table->string('sku');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('short_desc');
            $table->decimal('price');
            $table->string('link');
            $table->string('image');
            $table->string('brand');
            $table->integer('rating')->nullable();
            $table->string('caffeine_type')->nullable();
            $table->integer('count')->nullable();
            $table->string('flavored')->nullable();
            $table->string('seasonal')->nullable();
            $table->string('in_stock');
            $table->integer('facebook');
            $table->integer('is_KCup');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
