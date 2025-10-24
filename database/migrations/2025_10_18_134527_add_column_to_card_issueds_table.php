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
                'card_amount',
                'card_currency',
                'card_name',
                'email',
                'phone',
            ];

            foreach ($columns as $column) {
                $indexName = "idx_{$column}";
                $table->index($column, $indexName);
            }
        });

        Schema::table('transactions', function (Blueprint $table) {
            $columns = [
                'user_id',
                'business_id',
                'amount',
                'charge',
                'ref_id',
                'trx_type',
                'type',
                'status',
                'mode',
                'card_id',
                'card_currency',
                'card_country',
                'card_amount',
                'quantity',
                'name',
                'email',
                'phone',
                'phone_code',
                'currency',
                'rate'
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
