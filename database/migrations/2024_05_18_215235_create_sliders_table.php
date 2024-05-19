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
            $table->text('banner')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->unique()->nullable(); // example New Arival, Best Sales Product etc.
            $table->decimal('starting_price', 8, 2)->nullable();
            $table->string('btn_url')->nullable();
            $table->integer('serial')->unique()->nullable();
            $table->boolean('status')->nullable();

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
