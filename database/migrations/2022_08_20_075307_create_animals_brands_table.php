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
        Schema::create('animals_brands', function (Blueprint $table) {
            $table->id();
            $table->string('animal_brand')->unique();
            $table->foreignId('animal_id')
                    ->references('id')
                    ->on('animals')
                    ->cascadeOnDelete();
            $table->foreignId('brand_id')
                    ->references('id')
                    ->on('brands')
                    ->cascadeOnDelete();     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals_brands');
    }
};
