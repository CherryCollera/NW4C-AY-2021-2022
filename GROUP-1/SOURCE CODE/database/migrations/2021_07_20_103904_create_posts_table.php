<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->string('title');
            $table->text('description');
            $table->string('prod_name');
            $table->string('status');
            $table->double('est_price');
            $table->double('prod_qty')->nullable();
            $table->string('qty_type')->nullable();
            $table->date('date_produced')->nullable();
            $table->date('date_expiree')->nullable();
            $table->string('category')->nullable();
            $table->bigInteger('views')->nullable();
            $table->string('preferred_prod')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
