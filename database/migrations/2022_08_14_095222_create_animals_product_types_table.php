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
        Schema::create('animals_product_types', function (Blueprint $table) {
            $table->id();
            $table->string('animal_product_type')->unique();
            $table->string('image_path', 255)->nullable('false');      
            $table->foreignId('animal_id')
                    ->references('id')
                    ->on('animals')
                    ->onDelete('cascade');
            $table->foreignId('product_type_id')
                    ->nullable()
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
        Schema::dropIfExists('animal_categories');
    }
};
