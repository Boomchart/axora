<?php

namespace App\Observers;

use App\Models\Orders;
use App\Models\Business;
use App\Models\Settings;
use App\Models\Transactions;
use Illuminate\Support\Str;

class OrderObserver
{
    public function created(Orders $issue) {}

    public function updated(Orders $issue)
    {
        $issue = Orders::whereId($issue->id)->first();
        if ($issue->mode == 'live' && $issue->status == 'success' && $issue->agents && $issue->paid_agents == 0) {
            $totalRevAmount = [];
            foreach (json_decode($issue->agents, true) as $agent) {
                $revAmount = $totalRevAmount[] = ($issue->amount * $issue->rate * $agent['rev_pc'] / 100) +  $agent['rev_fc'];
                $agentAccount = Business::whereReference($agent['account_id'])->first();
                if ($agentAccount && $revAmount) {
                    $balance = $agentAccount->user->getFirstBalance();

                    Transactions::create([
                        'user_id' => $agentAccount->user_id,
                        'business_id' => $agent['account_id'],
                        'amount' => $revAmount,
                        'ref_id' => Str::uuid(),
                        'trx_type' => 'credit',
                        'type' => 'agent_payment',
                        'status' => 'success',
                        'currency' => Settings::find(1)->real->currency,
                        'agent_trx_id' => $issue->trx_id,
                        'issue_id' => $issue->id
                    ]);

                    $balance->update(['amount' => $balance->amount + $revAmount]);
                }
            }
            $issue->update([
                'paid_agents' => 1
            ]);
        }

        if ($issue->paid_profit == 0 && $issue->mode == 'live' && $issue->status == 'success') {
            $business = Business::whereChargeAccount(1)->first();
            if ($business) {
                $chargeAccountBalance = $business->user->getFirstBalance();
                $buyerAccountBalance = $issue->user->getFirstBalance();
                if ($issue->profit && Transactions::whereType('charge_account')->whereBusinessId($business->reference)->whereIssueId($issue->id)->whereAgentTrxId($issue->trx_id)->exists() == false) {
                    Transactions::create([
                        'user_id' => $business->user_id,
                        'business_id' => $business->reference,
                        'amount' => $issue->profit,
                        'ref_id' => Str::uuid(),
                        'trx_type' => 'credit',
                        'type' => 'charge_account',
                        'status' => 'success',
                        'currency' => Settings::find(1)->real->currency,
                        'agent_trx_id' => $issue->trx_id,
                        'issue_id' => $issue->id
                    ]);
                    $chargeAccountBalance->increment('amount', $issue->profit);
                }

                //Azora Discount
                if ($issue->discount) {
                    if (Transactions::whereType('charge_account_discount')->whereBusinessId($business->reference)->whereIssueId($issue->id)->whereAgentTrxId($issue->trx_id)->exists() == false) {
                        Transactions::create([
                            'user_id' => $business->user_id,
                            'business_id' => $business->reference,
                            'amount' => $issue->discount * 0.5,
                            'ref_id' => Str::uuid(),
                            'trx_type' => 'credit',
                            'type' => 'charge_account_discount',
                            'status' => 'success',
                            'currency' => Settings::find(1)->real->currency,
                            'agent_trx_id' => $issue->trx_id,
                            'issue_id' => $issue->id
                        ]);
                        $chargeAccountBalance->increment('amount', $issue->discount * 0.5);
                    }

                    if (Transactions::whereType('merchant_discount')->whereBusinessId($issue->business_id)->whereIssueId($issue->id)->whereAgentTrxId($issue->trx_id)->exists() == false) {
                        Transactions::create([
                            'user_id' => $issue->user_id,
                            'business_id' => $issue->business_id,
                            'amount' => $issue->discount * 0.5,
                            'ref_id' => Str::uuid(),
                            'trx_type' => 'credit',
                            'type' => 'merchant_discount',
                            'status' => 'success',
                            'currency' => Settings::find(1)->real->currency,
                            'agent_trx_id' => $issue->trx_id,
                            'issue_id' => $issue->id
                        ]);
                        $buyerAccountBalance->increment('amount', $issue->discount * 0.5);
                    }
                }

                //Mark profit as Paid
                $issue->update([
                    'paid_profit' => 1
                ]);
            }
        }
    }

    public function deleted(Orders $issue)
    {
        //
    }

    public function restored(Orders $issue)
    {
        //
    }

    public function forceDeleted(Orders $issue)
    {
        //
    }
}
