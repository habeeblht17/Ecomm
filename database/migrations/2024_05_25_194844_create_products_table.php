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
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('sub_category_id')->constrained('sub_categories')->cascadeOnDelete();
            $table->foreignId('chaild_category_id')->constrained('child_categories')->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->tinyText('short_description')->nullable();
            $table->longText('description');
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable(1);
            $table->string('sku')->unique(); //stock keeping unit.
            $table->unsignedBigInteger('quantity')->default(0);
            $table->enum('stock', ['instock', 'outofstock'])->default('outofstock');
            $table->enum('type', ['deliverable', 'downloadable'])->default('deliverable');

            $table->decimal('offer_price', 10, 2)->nullable();
            $table->date('offer_start_date')->nullable();
            $table->date('offer_end_date')->nullable();

            $table->string('image')->nullable();
            $table->date('published_at');
            $table->boolean('is_visible')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_appproved')->default(false);

            $table->boolean('is_top')->default(false);
            $table->boolean('is_best')->default(false);

            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();

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
