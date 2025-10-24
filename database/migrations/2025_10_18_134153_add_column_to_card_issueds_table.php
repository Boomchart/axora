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
            $table->double('card_amount')->default(0)->nullable();
            $table->string('card_currency')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('card_name')->nullable();
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
