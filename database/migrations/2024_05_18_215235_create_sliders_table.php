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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('banner')->nullable();
            $table->string('type')->unique()->nullable(); // example New Arival, Best Sales Product etc.
            $table->tinyText('description')->nullable();
            $table->decimal('starting_price', 8, 2)->nullable();
            $table->string('btn_url')->nullable();
            $table->integer('serial')->unique()->nullable();
            $table->boolean('is_visible')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
