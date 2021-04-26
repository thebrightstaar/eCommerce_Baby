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
            $table->double('price');
            $table->integer('discount')->nullable;
            $table->text('description');
            $table->string('image_1');
            $table->string('image_2')->default('0');
            $table->string('image_3')->default('0');
            $table->string('image_4')->default('0');
            $table->string('image_5')->default('0');
            $table->string('color');
            $table->text('product_name');
            $table->integer('quantity')->nullable;
            $table->integer('id_departmant');
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
