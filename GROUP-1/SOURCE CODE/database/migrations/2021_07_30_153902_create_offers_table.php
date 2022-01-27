<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id');
            $table->foreignId('user_id'); // user id of offerror
            $table->string('prod_name');
            $table->double('est_price');
            $table->double('prod_qty')->nullable();
            $table->string('qty_type')->nullable();
            $table->date('date_produced')->nullable();
            $table->date('date_expiree')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
