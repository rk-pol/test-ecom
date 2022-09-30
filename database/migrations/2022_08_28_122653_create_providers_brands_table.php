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
        Schema::create('providers_brands', function (Blueprint $table) {
            $table->id();
            $table->string('provider_brand')->unique();
            $table->foreignId('provider_id')
                    ->references('id')
                    ->on('providers')
                    ->onDelete('cascade');
            $table->foreignId('brand_id')
                    ->nullable()
                    ->references('id')
                    ->on('brands')
                    ->onDelete('set null');
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
        Schema::dropIfExists('providers_brands');
    }
};
