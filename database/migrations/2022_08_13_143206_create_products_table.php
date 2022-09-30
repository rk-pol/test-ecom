<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique()->nullable('false');
            $table->string('articul', 16)->unique()->nullable('false');
            $table->string('short_description', 255)->nullable();
            $table->text('long_description')->nullable('false');
            $table->string('image_path', 255)->nullable('flase');
            $table->decimal('price', 16, 2)->nullable('false');
            $table->boolean('is_new')->nullable();
            $table->foreignId('brand_id')
                  ->references('id')
                  ->on('brands')
                  ->onDelete('cascade');
            $table->foreignId('animal_id')
                  ->references('id')
                  ->on('animals')
                  ->onDelete('cascade');         
            $table->foreignId('product_type_id')
                  ->references('id')
                  ->on('product_types')
                  ->onDelete('cascade');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
