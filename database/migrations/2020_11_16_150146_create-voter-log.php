<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoterLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voter_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('contest_id');
            $table->integer('contestent_id');
            $table->string('voter_email');
            $table->integer('no_of_votes');
            $table->text('payment_info');
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
        //
    }
}
