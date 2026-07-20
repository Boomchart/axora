<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Settings, Transactions, CryptoBalance, CryptoAccount, Business};
use App\Services\Hasapay\HasapayService;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    protected $settings;

    public function __construct()
    {
        $this->settings = Settings::find(1);
    }

    public function processCryptoDeposit(CryptoAccount $crypto_account, array $data)
    {
        if ($crypto_account) {
            if (isset($crypto_account->cryptoBalance)) {
                if (\App\Models\Transactions::where('hasa_id', $data['data']['transaction_id'])->exists() == false) {
                    $balance = $crypto_account->cryptoBalance;
                    $amount = floatval($data['data']['amount_formatted']);
                    if ($amount > 0) {
                        $charge = calculateFee(
                            $amount,
                            $balance->crypto_wallet_ft,
                            (collect(json_decode($balance->crypto_wallet_agents, true) ?? [])->sum('rev_fc')) + $balance->crypto_wallet_fc,
                            (collect(json_decode($balance->crypto_wallet_agents, true) ?? [])->sum('rev_pc')) + $balance->crypto_wallet_pc,
                        );

                        $receiverBalBefore = $balance->amount;
                        $receiverBalAfter = $balance->amount + $amount - $charge;

                        $agents = $balance?->crypto_wallet_agents;

                        $transaction = Transactions::create([
                            'user_id' => $balance->user_id,
                            'business_id' => $balance->business_id,
                            'currency' => $balance->token,
                            'amount' => $amount - $charge,
                            'charge' => $charge,
                            'ref_id' => Str::uuid(),
                            'trx_type' => 'credit',
                            'type' => 'crypto_deposit',
                            'status' => 'success',
                            'crypto_wallet_id' => $balance->id,
                            'crypto_account_id' => $crypto_account->id,
                            'wallet_address' => $crypto_account->wallet_address,
                            'hasa_id' => $data['data']['transaction_id'],
                            'balanceBefore' => $receiverBalBefore,
                            'balanceAfter' => $receiverBalAfter,
                            'agents' => $agents,
                            'trx_hash' => $data['data']['tx_hash']
                        ]);

                        dispatch(new \App\Jobs\Webhook\CryptoDeposit($transaction))->delay(now()->addMinute());
                        logBalance($balance->id, ($amount - $charge), 'credit', $transaction->id, 'amount', true);

                        if (!empty(json_decode($agents, true))) {
                            $totalRevAmount = [];
                            foreach (json_decode($agents, true) as $agent) {
                                $revAccount = Business::whereReference($agent['account_id'])->first();
                                $mainBalance = CryptoBalance::whereBusinessId($agent['account_id'])->whereToken($balance->token)->whereNetwork($balance->network)->whereMode('live')->first();

                                if ($revAccount && $mainBalance) {
                                    $exists = Transactions::whereTrxType('credit')->whereBusinessId($agent['account_id'])->whereRevShareId($transaction->id)->exists();

                                    if ($exists == false) {
                                        $revAmount = ($transaction->amount * $agent['rev_pc'] / 100) + ($agent['rev_fc']);
                                        $totalRevAmount[] = $revAmount;

                                        $agentBalBefore = $mainBalance->amount;
                                        $agentBalAfter = $mainBalance->amount + $revAmount;

                                        $newTrx = \App\Models\Transactions::create([
                                            'user_id' => $revAccount->user_id,
                                            'business_id' => $revAccount->reference,
                                            'currency' => $mainBalance->token,
                                            'amount' => $revAmount,
                                            'ref_id' => Str::uuid(),
                                            'trx_type' => 'credit',
                                            'type' => 'agent_payment',
                                            'rev_share' => 1,
                                            'status' => 'success',
                                            'balanceBefore' => $agentBalBefore,
                                            'balanceAfter' => $agentBalAfter,
                                            'crypto_wallet_id' => $mainBalance->id,
                                            'rev_share_id' => $transaction->id,
                                            'trx_hash' => $data['data']['tx_hash']
                                        ]);

                                        logBalance($mainBalance->id, $revAmount, 'credit', $newTrx->id, 'amount', true);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function hasapay(Request $request)
    {
        $payload = $request->getContent();

        $signature = $request->header('x-hasapay-signature');

        $hasapay = new HasapayService();

        if (!$signature || !$hasapay->verifyWebhookSignature($payload, $signature)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = $request->all();

        if (in_array(strtolower($data['event']), ['deposit.confirmed', 'withdrawal.completed', 'withdrawal.failed'])) {
            if ($data['event'] == 'deposit.confirmed') {
                $crypto_account = CryptoAccount::where('hasa_deposit_code', $data['data']['to']['child_address_id'])->first();
                if ($crypto_account) {
                    $hasapay = new HasapayService();
                    $coins = $hasapay->walletData();
                    $coin = collect($coins)
                        ->where('network_name', $data['data']['network'])
                        ->where('chain', $data['data']['chain'])
                        ->where('token', $data['data']['token_symbol'])
                        ->first();

                    if ($coin) {
                        if ($coin['token'] == $crypto_account->token && $coin['network'] == $crypto_account->network) {
                            $this->processCryptoDeposit($crypto_account->id, $data);
                        } else {
                            $correct_crypto_account = CryptoAccount::whereMode($crypto_account->mode)->whereNetwork($coin['network'])->whereToken($coin['token'])->first();
                            if ($correct_crypto_account) {
                                $this->processCryptoDeposit($correct_crypto_account->id, $data);
                            }
                        }
                    }
                }
            } else {
                $val = Transactions::whereType('crypto_payout')->whereHasaId($data['data']['transaction_id'])->first();
                if ($val) {
                    if ($data['event'] == 'withdrawal.completed') {
                        $val->update([
                            'status' => 'success',
                            'trx_hash' => $data['data']['tx_hash']
                        ]);
                        $transaction = $val;

                        if (!empty(json_decode($transaction->agents, true))) {
                            $totalRevAmount = [];
                            foreach (json_decode($transaction->agents, true) as $agent) {
                                $revAccount = Business::whereReference($agent['account_id'])->first();
                                $mainBalance = CryptoBalance::whereBusinessId($agent['account_id'])->whereToken($transaction->cryptoBalance->token)->whereNetwork($transaction->cryptoBalance->network)->whereMode('live')->first();

                                if ($revAccount && $mainBalance) {
                                    $exists = Transactions::whereTrxType('credit')->whereBusinessId($agent['account_id'])->whereRevShareId($transaction->id)->exists();

                                    if ($exists == false) {
                                        $revAmount = ($transaction->amount * $agent['rev_pc'] / 100) + ($agent['rev_fc']);
                                        $totalRevAmount[] = $revAmount;

                                        $agentBalBefore = $mainBalance->amount;
                                        $agentBalAfter = $mainBalance->amount + $revAmount;

                                        $newTrx = \App\Models\Transactions::create([
                                            'user_id' => $revAccount->user_id,
                                            'business_id' => $revAccount->reference,
                                            'currency' => $mainBalance->token,
                                            'amount' => $revAmount,
                                            'ref_id' => Str::uuid(),
                                            'trx_type' => 'credit',
                                            'type' => 'agent_payment',
                                            'rev_share' => 1,
                                            'status' => 'success',
                                            'balanceBefore' => $agentBalBefore,
                                            'balanceAfter' => $agentBalAfter,
                                            'crypto_wallet_id' => $mainBalance->id,
                                            'rev_share_id' => $transaction->id,
                                        ]);

                                        logBalance($mainBalance->id, $revAmount, 'credit', $newTrx->id, 'amount', true);
                                    }
                                }
                            }
                        }

                        dispatch(new \App\Jobs\CustomEmail('withdraw_request_approve', $transaction->id));
                        dispatch(new \App\Jobs\Webhook\CryptoPayout($transaction))->delay(now()->addMinute());
                    }
                }
            }
        }

        return response(200);
    }

    public function redboxx(Request $request)
    {
        $secret = config('services.redboxx_webhook_hash');
        $signature = $request->header('webhook-secret');

        // Get the raw body instead of parsed data
        $payload = $request->getContent();
        $sign_secret = hash_hmac('sha256', $payload, $secret);

        // Use hash_equals for timing-safe comparison
        if (!$signature || !hash_equals($sign_secret, $signature)) {
            abort(401);
        }

        $payload = (array) $request->all();

        if ($payload['event'] == 'issued') {
            $issue = \App\Models\Orders::whereOrderId($payload['data']['id'])->first();
            if ($issue) {
                if ($issue->status == 'pending') {
                    $issue->update([
                        'status' => $payload['data']['status'],
                        'card_code' => encryptRSA($payload['data']['card_code']),
                        'card_url' => encryptRSA($payload['data']['card_url']),
                        'data' => json_encode($payload['data']),
                    ]);

                    if ($payload['data']['status'] == 'success') {
                        if ($issue->business_id) {
                            if ($issue->business->webhook_url) {
                                dispatch(new \App\Jobs\Webhook\Giftcard($issue));
                            }
                        }
                    }
                }
            }
        } elseif ($payload['event'] == 'redemption') {
            $issue = \App\Models\Orders::whereOrderId($payload['data']['id'])->first();
            if ($issue) {
                $issue->update([
                    'card_code' => encryptRSA($payload['data']['card_code']),
                    'card_url' => encryptRSA($payload['data']['card_url']),
                ]);
                if ($issue->business_id) {
                    if ($issue->business->webhook_url) {
                        dispatch(new \App\Jobs\Webhook\Redemption($payload['data'], $issue));
                    }
                }
            }
        }
    }
}
