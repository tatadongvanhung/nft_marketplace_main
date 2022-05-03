<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteTableTransactionlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('transactionlogs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('transactionlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('from')->nullable();
            $table->text('to')->nullable();
            $table->string('action')->nullable();
            // $table->float('ethPrice')->nullable();
            // $table->float('usdPrice')->nullable();
            $table->double('ethPrice', 15, 8);
            $table->double('usdPrice', 15, 8);
            $table->unsignedInteger('tokenId')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
