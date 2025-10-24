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
        Schema::create('card_issueds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->uuid('business_id')->nullable();
            $table->uuid('order_id')->nullable();
            $table->uuid('trx_id')->nullable();
            $table->uuid('card_id')->nullable();
            $table->double('amount')->default(0)->nullable();
            $table->double('profit')->default(0)->nullable();
            $table->double('rev_share')->default(0)->nullable();
            $table->double('rate')->default(0)->nullable();
            $table->text('data')->nullable();
            $table->string('status')->nullable();
            $table->string('currency')->nullable();
            $table->text('name')->nullable();
            $table->string('mode')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->longtext('redboxx_low_notify')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_issueds');
    }
};
