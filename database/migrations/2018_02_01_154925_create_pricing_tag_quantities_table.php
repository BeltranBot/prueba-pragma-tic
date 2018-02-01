<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricingTagQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_tag_quantities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pricing_id');
            $table->integer('quantity');
            $table->double('subtotal', 14, 4);
            $table->double('total', 14, 4);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('pricing_id')->references('id')->on('pricings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('pricing_tag_quantities', function (Blueprint $table) {
            $table->dropForeign(['pricing_id']);
        });
        Schema::dropIfExists('pricing_tag_quantities');
    }
}
