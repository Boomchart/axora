<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('card_issueds', function (Blueprint $table) {
            $table->text('agents')->nullable();
            $table->integer('paid_agents')->default(0)->nullable();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('agent_trx_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
