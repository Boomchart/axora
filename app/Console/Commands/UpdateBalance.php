<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\BalanceLog;
use App\Models\Balance;

class UpdateBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Balance';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Crypto Main Amount
        DB::transaction(function () {
            // Get all current IDs
            $ids = DB::table('balance_logs')->whereType('amount')->whereCrypto(1)->pluck('id')->all();

            if (empty($ids)) {
                return;
            }

            DB::statement("
                UPDATE crypto_balances b
                JOIN (
                    SELECT 
                        balance_id,
                        SUM(CASE WHEN trx_type = 'credit' AND type = 'amount' THEN amount ELSE 0 END) -
                        SUM(CASE WHEN trx_type = 'debit' AND type = 'amount' THEN amount ELSE 0 END) as net_amount
                    FROM balance_logs
                    WHERE id IN ('" . implode("','", $ids) . "')
                    GROUP BY balance_id
                ) logs ON b.id = logs.balance_id
                SET b.amount = b.amount + logs.net_amount
            ");

            DB::statement("
                UPDATE crypto_currencies c
                JOIN (
                    SELECT 
                        currency_id,
                        SUM(CASE WHEN trx_type = 'credit' AND type = 'amount' THEN amount ELSE 0 END) -
                        SUM(CASE WHEN trx_type = 'debit' AND type = 'amount' THEN amount ELSE 0 END) as net_amount
                    FROM balance_logs
                    WHERE currency_id IS NOT NULL
                    AND id IN ('" . implode("','", $ids) . "')
                    GROUP BY currency_id
                ) logs ON c.id = logs.currency_id
                SET c.balance_amount = c.balance_amount + logs.net_amount
            ");

            DB::table('balance_logs')->whereIn('id', $ids)->delete();
        });
        return Command::SUCCESS;
    }
}
