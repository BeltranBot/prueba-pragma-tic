<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('printing_type_id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('printer_id');
            $table->unsignedInteger('operator_id');
            $table->unsignedInteger('paper_id');

            $table->decimal('tag_width', 9, 4);
            $table->decimal('tag_height', 9, 4);
            $table->decimal('tag_area', 9, 4);
            $table->double('paper_cost', 14, 4);
            $table->double('operator_cost', 14, 4);
            $table->decimal('printing_time', 14, 4);

            $table->decimal('wasted_paper', 7, 4)->nullable();
            $table->decimal('prep_time', 7, 2)->nullable();
            $table->integer('inks_number')->nullable();

            $table->decimal('utility', 7, 4);
            

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('printing_type_id')->references('id')->on('printing_types');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('printer_id')->references('id')->on('printers');
            $table->foreign('operator_id')->references('id')->on('operators');
            $table->foreign('paper_id')->references('id')->on('papers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('princings', function (Blueprint $table) {
            $table->dropForeign(['paper_id']);
            $table->dropForeign(['operator_id']);
            $table->dropForeign(['printer_id']);
            $table->dropForeign(['client_id']);
            $table->dropForeign(['printing_type_id']);
        });
        Schema::dropIfExists('pricings');
    }
}
