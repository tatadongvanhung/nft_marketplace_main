<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
class SetNullColumnToTransactionlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactionlogs', function (Blueprint $table) {
            // $table->double('ethPrice', 15, 8)->nullable()->change();
            // $table->double('usdPrice', 15, 8)->nullable()->change();
            DB::statement('alter table transactionlogs modify ethPrice DOUBLE(15,8) NULL');
            DB::statement('alter table transactionlogs modify usdPrice DOUBLE(15,8) NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactionlogs', function (Blueprint $table) {
            DB::statement('alter table transactionlogs modify ethPrice DOUBLE(15,8) NULL');
            DB::statement('alter table transactionlogs modify usdPrice DOUBLE(15,8) NULL');
        });
    }
}
