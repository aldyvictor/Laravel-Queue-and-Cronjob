<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('name');
            $table->integer('price');
            $table->string('product_image_original_name');
            $table->string('product_image_original_url');
            $table->string('product_image_large_name');
            $table->string('product_image_large_url');
            $table->string('product_image_medium_name');
            $table->string('product_image_medium_url');
            $table->string('product_image_small_name');
            $table->string('product_image_small_url');
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
}
