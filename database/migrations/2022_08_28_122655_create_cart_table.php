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
        Schema::create('cart', function (Blueprint $table) {
            $table->id('id');          
            $table->string('user_id')->nullable();
            $table->text('p_uuid')
                    ->nullable();  
            $table->foreignId('product_id')
                    ->references('id')
                    ->on('products')
                    ->cascadeOnDelete(); 
            $table->integer('amount')->nullable('false');     
            $table->decimal('price', 16, 2)->nullable('false');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
