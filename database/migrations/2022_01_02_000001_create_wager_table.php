<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wagers', function (Blueprint $table) {
            $table->id();
            $table->float('total_wager_value');
            $table->float('odds');
            $table->float('selling_percentage');
            $table->float('selling_price');
            $table->float('current_selling_price');
            $table->float('percentage_sold');
            $table->float('amount_sold');
            $table->timestamp('placed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wagers');
    }
}