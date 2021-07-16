<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('bsgId');
            $table->string('name');
            $table->string('shortName');
            $table->integer('price');
            $table->integer('basePrice');
            $table->integer('avg24hPrice');
            $table->integer('avg7daysPrice');
            $table->string('traderName');
            $table->integer('traderPrice');
            $table->string('traderPriceCur');
            $table->integer('slots');
            $table->integer('diff24h');
            $table->integer('diff7days');
            $table->string('icon');
            $table->string('link');
            $table->string('wikiLink');
            $table->string('img');
            $table->string('imgBig');
            $table->string('referance');
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
        Schema::dropIfExists('items');
    }
}
