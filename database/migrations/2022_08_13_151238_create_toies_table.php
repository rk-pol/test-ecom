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
        Schema::create('toies', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->nullable('false');
            $table->string('demensions', 50)->nullable();
            $table->string('material', 50)->nullable();
            $table->integer('age')->nullable();
            $table->foreignId('product_id')
                    ->references('id')
                    ->on('products')
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
        Schema::dropIfExists('toies');
    }
};
