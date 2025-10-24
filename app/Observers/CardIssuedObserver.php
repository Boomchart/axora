<?php

namespace App\Observers;

use App\Models\CardIssued;
use App\Models\Business;
use App\Models\Settings;
use App\Models\Transactions;
use Illuminate\Support\Str;

class CardIssuedObserver
{
    public function created(CardIssued $issue)
    {
        $issue = CardIssued::whereId($issue->id)->first();
        if ($issue->paid_profit == 0 && $issue->mode == 'live') {
            $business = Business::whereChargeAccount(1)->first();
            $balance = $business->user->getFirstBalance();
            Transactions::create([
                'user_id' => $business->user_id,
                'business_id' => $business->reference,
                'amount' => $issue->redboxx_share,
                'ref_id' => Str::uuid(),
                'trx_type' => 'credit',
                'type' => 'charge_account',
                'status' => 'success',
                'currency' => Settings::find(1)->real->currency,
                'issue_id' => $issue->id
            ]);
            $balance->update(['amount' => $balance->amount + $issue->redboxx_share]);
            $issue->update([
                'paid_profit' => 1
            ]);
        }
    }

    public function updated(CardIssued $issue)
    {
        $issue = CardIssued::whereId($issue->id)->first();
        if ($issue->mode == 'live' && $issue->status == 'success' && $issue->agents && $issue->paid_agents == 0) {
            $totalRevAmount = [];
            foreach (json_decode($issue->agents, true) as $agent) {
                $revAmount = $totalRevAmount[] = ($issue->transaction->amount * $agent['rev_pc'] / 100) +  $agent['rev_fc'];
                $agentAccount = Business::whereReference($agent['account_id'])->first();
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
            $issue->update([
                'paid_agents' => 1
            ]);
        }
    }

    public function deleted(CardIssued $issue)
    {
        //
    }

    public function restored(CardIssued $issue)
    {
        //
    }

    public function forceDeleted(CardIssued $issue)
    {
        //
    }
}
