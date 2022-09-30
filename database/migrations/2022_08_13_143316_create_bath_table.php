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
        Schema::create('bath', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100)->change()->nullable('false');
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
        Schema::dropIfExists('baths');
    }
};
