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
            $columns = [
                'user_id',
                'business_id',
                'trx_id',
                'order_id',
                'card_id',
                'rate',
                'amount',
                'profit',
                'rev_share',
                'status',
                'currency',
                'mode',
                'expires',
                'paid_agents',
                'paid_profit',
                'redboxx_share',
            ];

            foreach ($columns as $column) {
                $indexName = "idx_{$column}";
                $table->index($column, $indexName);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_issueds', function (Blueprint $table) {
            //
        });
    }
};
