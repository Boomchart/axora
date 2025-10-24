<?php

namespace App\Jobs\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CalculateDashboardBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle()
    {
        $balances = \App\Models\Balance::whereMode('live')->orderBy('short_code', 'asc')->get();
        $stats = $balances->groupBy(function ($item) {
            return $item->short_code;
        })->filter(function ($item) {
            return ($item->sum('amount') > 0 || $item->sum('hold') > 0);
        })->sortKeys()->map(function ($item, $key) {

            $gateway_data = \App\Models\Transactions::whereCurrencyCode($key)
                ->whereIn('type', ['credit_transfer'])
                ->whereStatus('success')
                ->whereMode('live')
                ->whereIn('gateway_name', ['pay_agency', 'stellarity', 'cryptochill'])
                ->selectRaw('gateway_name, SUM(amount) as total_amount, SUM(charge) as total_charge')
                ->groupBy('gateway_name')
                ->get()
                ->keyBy('gateway_name');

            $chargeback_data = \App\Models\Transactions::whereCurrencyCode($key)
                ->whereIn('type', ['chargeback'])
                ->whereStatus('success')
                ->whereMode('live')
                ->whereIn('gateway_name', ['pay_agency', 'stellarity', 'cryptochill'])
                ->selectRaw('gateway_name, SUM(amount) as total_amount, SUM(charge) as total_charge')
                ->groupBy('gateway_name')
                ->get()
                ->keyBy('gateway_name');

            $revshare_data = \App\Models\Transactions::whereCurrencyCode($key)
                ->where('payment_collection_agent', 1)
                ->whereMode('live')
                ->whereStatus('success')
                ->selectRaw('gateway_name, SUM(amount) as total_amount')
                ->groupBy('gateway_name')
                ->pluck('total_amount', 'gateway_name');

            $payAgencyChargeData = DB::table('transactions')
                ->whereCurrencyCode($key)
                ->whereIn('type', ['credit_transfer'])
                ->where('status', 'success')
                ->whereNotNull('pay_agency_terminal_id')
                ->where('gateway_name', 'pay_agency')
                ->selectRaw('
                        pay_agency_terminal_id,
                        SUM(charge) as charge,
                        SUM(rev_share_amount) as total_rev_share_amount,
                        COUNT(*) as transaction_count
                    ')
                ->groupBy('pay_agency_terminal_id')
                ->orderBy('pay_agency_terminal_id')
                ->get()
                ->keyBy('pay_agency_terminal_id')
                ->map(function ($item) {
                    return [
                        'pay_agency_terminal_id' => $item->pay_agency_terminal_id,
                        'charge' => (float) $item->charge,
                        'total_rev_share_amount' => (float) $item->total_rev_share_amount,
                        'total_charge' => (float) ($item->charge - $item->total_rev_share_amount),
                        'total_charge_after_flat_fee' => (float) (($item->charge - $item->total_rev_share_amount) - (0.3 * $item->transaction_count)),
                        'stratos_profit' => (float) ((($item->charge - $item->total_rev_share_amount) - (0.3 * $item->transaction_count)) * 1.5 / 7),
                    ];
                });

            $T3363412 = collect($payAgencyChargeData)->get('T3363412')['stratos_profit'] ?? 0;
            $T3623682 = collect($payAgencyChargeData)->get('T3623682')['stratos_profit'] ?? 0;

            $stratos_profit = $T3363412 + $T3623682;

            return [
                'main_balance' => $item->sum('amount'),
                'hold_balance' => $item->sum('hold'),
                'credit_transfer' => $item->sum('credit_transfer'),
                'deposit' => $item->sum('deposit'),
                'account_reconciliation_credit' => $item->sum('account_reconciliation_credit'),
                'account_reconciliation_debit' => $item->sum('account_reconciliation_debit'),
                'payout' => $item->sum('payout'),
                'pay_agency_amount' => $gateway_data->get('pay_agency')->total_amount ?? 0,
                'pay_agency_charge' => $gateway_data->get('pay_agency')->total_charge ?? 0,
                'pay_agency_chargeback' => $chargeback_data->get('pay_agency')->total_amount ?? 0,
                'stellarity_amount' => $gateway_data->get('stellarity')->total_amount ?? 0,
                'stellarity_charge' => $gateway_data->get('stellarity')->total_charge ?? 0,
                'stellarity_chargeback' => $chargeback_data->get('stellarity')->total_amount ?? 0,
                'cryptochill_amount' => $gateway_data->get('cryptochill')->total_amount ?? 0,
                'cryptochill_charge' => $gateway_data->get('cryptochill')->total_charge ?? 0,
                'cryptochill_chargeback' => $chargeback_data->get('cryptochill')->total_amount ?? 0,
                'rev_share' => $revshare_data->sum(),
                'pay_agency_rev' => $revshare_data->get('pay_agency', 0),
                'stellarity_rev' => $revshare_data->get('stellarity', 0),
                'cryptochill_rev' => $revshare_data->get('cryptochill', 0),
                'stratos_profit' => $stratos_profit,
            ];
        });

        // Cache for 24 hours
        Cache::put('dashboard_balance', $stats, 86400);
    }
}
