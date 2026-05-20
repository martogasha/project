<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('product_name');
            $table->integer('quantity');
            $table->integer('number_of_pack')->nullable();
            $table->integer('selling_price');
            $table->string('date');
            $table->string('total');
            $table->mediumText('image')->nullable();
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
        Schema::dropIfExists('sell_hotels');
    }
}
