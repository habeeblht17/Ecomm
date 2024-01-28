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
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->tinyText('short_description');
            $table->longText('description');
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable(1);
            $table->string('sku')->unique(); //stock keeping unit.
            $table->enum('stock', ['instock', 'outofstock'])->default('outofstock');
            $table->enum('type', ['deliverable', 'downloadable'])->default('deliverable');
            $table->unsignedBigInteger('quantity')->default(0);
            $table->boolean('is_visible')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('image');
            $table->date('published_at');
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
