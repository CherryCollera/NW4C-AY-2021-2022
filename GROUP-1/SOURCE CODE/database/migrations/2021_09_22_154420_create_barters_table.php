<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBartersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('finished_at')->nullable();
            $table->foreignId('post_id'); //remove post_id
            $table->foreignId('convo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barters');
    }
}
