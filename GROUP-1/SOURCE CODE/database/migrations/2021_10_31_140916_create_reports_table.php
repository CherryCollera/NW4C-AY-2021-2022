<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->foreignId('reported_post_id');
            $table->foreignId('reported_user_id');
            $table->text('description');
            $table->string('report_type');
            $table->string('action_taken')->nullable();
            $table->foreignId('mod_assigned')->nullable();
            $table->boolean('is_resolved')->nullable();
            $table->text('mod_notes')->nullable();
            $table->integer('offense_level')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
