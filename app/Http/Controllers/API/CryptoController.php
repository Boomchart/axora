<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\{CryptoBalanceResource, CryptoAccountResource};
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use App\Models\{Settings, Transactions, CryptoBalance, CryptoAccount};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\ClientAuthenticate;
use Illuminate\Support\Facades\DB;
use App\Services\Hasapay\HasapayService;

class CryptoController extends Controller
{
    use ClientAuthenticate;
    public mixed $settings;

    public function __construct()
    {
        $this->settings = Settings::find(1);
    }

    public function assets(Request $request, $asset = null)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            $this->ipCheck();
            if ($this->security_check) {
                return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
            }
            if ($asset) {
                if (CryptoBalance::whereId($asset)->whereBusinessId($this->client->reference)->exists()) {
                    $resource = CryptoBalance::whereId($asset)->whereBusinessId($this->client->reference)->first();
                    $apiresponse = ['message' => __('Asset details'), 'status' => 'success', 'data' => new CryptoBalanceResource($resource, $this->client)];
                    $this->logError(200, $apiresponse);
                    return response()->json($apiresponse, 200);
                } else {
                    $apiresponse = ['message' => __('Asset not found'), 'status' => 'failed', 'data' => null];
                    $this->logError(404, $apiresponse);
                    return response()->json($apiresponse, 404);
                }
            } else {
                $resource = CryptoBalance::whereBusinessId($this->client->reference)->with(['getCurrency'])->orderBy('token', 'asc')->get();
                $apiresponse = ['message' => __('Assets'), 'status' => 'success', 'data' => CryptoBalanceResource::collection($resource)->map(fn($resource) => new CryptoBalanceResource($resource, $this->client))];
                $this->logError(200, (array) $apiresponse);
                return $apiresponse;
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function addresses(Request $request, string $asset, $address = null)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            $this->ipCheck();
            if ($this->security_check) {
                return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
            }
            if ($address) {
                if (CryptoAccount::whereBalanceId($asset)->whereBusinessId($this->client->reference)->whereMode($this->mode)->whereType('customer')->whereId($address)->exists()) {
                    $resource = CryptoAccount::whereBalanceId($asset)->whereBusinessId($this->client->reference)->whereMode($this->mode)->whereType('customer')->whereId($address)->first();
                    $apiresponse = ['message' => __('Address details'), 'status' => 'success', 'data' => new CryptoAccountResource($resource)];
                    $this->logError(200, $apiresponse);
                    return response()->json($apiresponse, 200);
                } else {
                    $apiresponse = ['message' => __('Address not found'), 'status' => 'failed', 'data' => null];
                    $this->logError(404, $apiresponse);
                    return response()->json($apiresponse, 404);
                }
            } else {
                $resource = CryptoAccount::whereBalanceId($asset)->whereBusinessId($this->client->reference)->whereMode($this->mode)->whereType('customer')->when($request->page == 'all', fn($query) => $query->get(), fn($query) => $query->paginate($limit ?? 20));
                $apiresponse = ['message' => __('Addresses'), 'status' => 'success', 'data' => CryptoAccountResource::collection($resource)->map(fn($resource) => new CryptoAccountResource($resource))];
                $this->logError(200, (array) $apiresponse);
                return $apiresponse;
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function createAddress(Request $request)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            $this->ipCheck();
            if ($this->security_check) {
                return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
            }
            $validator = Validator::make($request->all(), [
                'label' => ['required', 'string', 'max:255'],
                'asset_id' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                $apiresponse = [
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                    'status' => 'failed',
                    'data' => null,
                ];
                $this->logError(422, $apiresponse);
                return response()->json($apiresponse, 422);
            }

            $lockKey = 'request_lock_' . $this->client->reference;
            $lockDuration = 3; // seconds

            $lock = cache()->lock($lockKey, $lockDuration);

            if (!$lock->get()) {
                $apiresponse = ['message' => __('Please wait a moment before trying again'), 'status' => 'failed', 'data' => null];
                $this->logError(429, $apiresponse);
                return response()->json($apiresponse, 429);
            }

            try {
                return DB::transaction(function () use ($request) {
                    $account = CryptoBalance::whereId($request->asset_id)->whereBusinessId($this->client->reference)->first();
                    if ($account) {
                        $hasapay = new HasapayService($this->mode);
                        $wallet = $hasapay->fetchWalletId($account->token, $account->network);
                        if (CryptoAccount::whereBusinessId($this->client->reference)->whereMode($this->mode)->whereLabel($request->label)->exists()) {
                            $msg = __('Label has been used before');
                            $apiresponse = ['message' => $msg, 'errors' => ['label' => [$msg]], 'status' => 'failed', 'data' => null];
                            $this->logError(422, $apiresponse);
                            return response()->json($apiresponse, 422);
                        }
                        if ($this->mode == 'live') {
                            $address = $hasapay->generateAddress($wallet['wallet_id'], $request->label);
                            if ($address['success'] == true) {
                                $new = CryptoAccount::create([
                                    'label' => $request->label,
                                    'token' => $account->token,
                                    'network' => $account->network,
                                    'balance_id' => $account->id,
                                    'user_id' => $account->user_id,
                                    'business_id' => $account->business_id,
                                    'wallet_address' => $address['data']['address'],
                                    'hasapay_deposit_code' => $address['data']['id'],
                                    'type' => 'customer',
                                    'mode' => $this->mode
                                ]);
                                $apiresponse = ['message' => __('Address generated'), 'status' => 'success', 'data' => new CryptoAccountResource($new)];
                                $this->logError(200, $apiresponse);
                                return response()->json($apiresponse, 200);
                            } else {
                                $msg = $address['error'];
                                $apiresponse = ['message' => $msg, 'errors' => ['asset_id' => [$msg]], 'status' => 'failed', 'data' => null];
                                $this->logError(422, $apiresponse);
                                return response()->json($apiresponse, 422);
                            }
                        } else {
                            $new = CryptoAccount::create([
                                'label' => $request->label,
                                'user_id' => $this->client->user_id,
                                'business_id' => $this->client->reference, //merchant
                                'balance_id' => $account->id,
                                'wallet_address' => generateTestWalletAddress($account->network, $account->token),
                                "token" => strtoupper($account->token),
                                "network" => strtoupper($account->network),
                                'mode' => $this->mode,
                                'type' => 'customer',
                            ]);

                            $apiresponse = ['message' => __('Address generated'), 'status' => 'success', 'data' => new CryptoAccountResource($new)];
                            $this->logError(200, $apiresponse);
                            return response()->json($apiresponse, 200);
                        }
                    } else {
                        $apiresponse = ['message' => __('Asset not found'), 'status' => 'failed', 'data' => null];
                        $this->logError(404, $apiresponse);
                        return response()->json($apiresponse, 404);
                    }
                }, 3);
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' =>  __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            } finally {
                $lock->release();
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function payoutQuote(Request $request)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            $this->ipCheck();
            if ($this->security_check) {
                return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
            }
            $validator = Validator::make($request->all(), [
                'amount' => ['required', 'numeric', 'min:0'],
                'address_id' => ['required', 'string'],
                'to_address' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                $apiresponse = [
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                    'status' => 'failed',
                    'data' => null,
                ];
                $this->logError(422, $apiresponse);
                return response()->json($apiresponse, 422);
            }

            $lockKey = 'request_lock_' . $this->client->reference;
            $lockDuration = 3; // seconds

            $lock = cache()->lock($lockKey, $lockDuration);

            if (!$lock->get()) {
                $apiresponse = ['message' => __('Please wait a moment before trying again'), 'status' => 'failed', 'data' => null];
                $this->logError(429, $apiresponse);
                return response()->json($apiresponse, 429);
            }


            try {
                return DB::transaction(function () use ($request) {
                    $address = CryptoAccount::whereId($request->address_id)->whereMode($this->mode)->whereBusinessId($this->client->reference)->first();
                    if ($address) {

                        $result = verifyWalletAddress($request->to_address, $address->token, $address->network);
                        if ($result['valid'] == false) {
                            $msg = $result['reason'];
                            $apiresponse = ['message' => $msg, 'errors' => ['to_address' => [$msg]], 'status' => 'failed', 'data' => null];
                            $this->logError(422, $apiresponse);
                            return response()->json($apiresponse, 422);
                        }

                        $hasapay = new HasapayService($this->mode);
                        $wallet = $hasapay->fetchWalletId($address->token, $address->network);

                        $estimate = $hasapay->estimateGasFee(
                            $wallet['token'],
                            $wallet['chain'],
                            $wallet['network_name'],
                            removeCommas($request->amount)
                        );

                        if ($estimate['success'] == true) {
                            $flat = (float)$address->cryptoBalance->crypto_wallet_payout_fc + collect(json_decode($address->cryptoBalance->crypto_wallet_payout_agents, true) ?? [])->sum('rev_fc');
                            $percent = (float)$address->cryptoBalance->crypto_wallet_payout_pc + collect(json_decode($address->cryptoBalance->crypto_wallet_payout_agents, true) ?? [])->sum('rev_pc');

                            $apiresponse = ['message' => __('Estimate Calculated'), 'status' => 'success', 'data' => [
                                'gas_fee' => $estimate['data']['total_fee']['amount'],
                                'azora_charge' => ($request->amount * $percent / 100) + $flat,
                                'total' => (($request->amount * $percent / 100) + $flat) + $estimate['data']['total_fee']['amount'],
                            ]];
                            $this->logError(200, $apiresponse);
                            return response()->json($apiresponse, 200);
                        } else {
                            $msg = $estimate['error'];
                            $apiresponse = ['message' => $msg, 'errors' => ['to_address' => [$msg]], 'status' => 'failed', 'data' => null];
                            $this->logError(422, $apiresponse);
                            return response()->json($apiresponse, 422);
                        }
                    } else {
                        $apiresponse = ['message' => __('Address not found'), 'status' => 'failed', 'data' => null];
                        $this->logError(404, $apiresponse);
                        return response()->json($apiresponse, 404);
                    }
                }, 3);
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' =>  __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            } finally {
                $lock->release();
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function payout(Request $request)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            $this->ipCheck();
            if ($this->security_check) {
                return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
            }
            $validator = Validator::make($request->all(), [
                'amount' => ['required', 'numeric', 'min:0'],
                'asset_id' => ['required', 'string'],
                'to_address' => ['required', 'string'],
                'external_reference' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                $apiresponse = [
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                    'status' => 'failed',
                    'data' => null,
                ];
                $this->logError(422, $apiresponse);
                return response()->json($apiresponse, 422);
            }

            $lockKey = 'request_lock_' . $this->client->reference;
            $lockDuration = 3; // seconds

            $lock = cache()->lock($lockKey, $lockDuration);

            if (!$lock->get()) {
                $apiresponse = ['message' => __('Please wait a moment before trying again'), 'status' => 'failed', 'data' => null];
                $this->logError(429, $apiresponse);
                return response()->json($apiresponse, 429);
            }


            try {
                return DB::transaction(function () use ($request) {
                    $account = CryptoBalance::whereId($request->asset_id)->whereBusinessId($this->client->reference)->first();
                    if ($account) {

                        $result = verifyWalletAddress($request->to_address, $account->token, $account->network);
                        if ($result['valid'] == false) {
                            $msg = $result['reason'];
                            $apiresponse = ['message' => $msg, 'errors' => ['to_address' => [$msg]], 'status' => 'failed', 'data' => null];
                            $this->logError(422, $apiresponse);
                            return response()->json($apiresponse, 422);
                        }

                        if (Transactions::whereBusinessId($this->client->reference)->whereExternalReference($request->external_reference)->exists()) {
                            $msg = __('external_reference has been used before');
                            $apiresponse = ['message' => $msg, 'errors' => ['external_reference' => [$msg]], 'status' => 'failed', 'data' => null];
                            $this->logError(422, $apiresponse);
                            return response()->json($apiresponse, 422);
                        }

                        $hasapay = new HasapayService($this->mode);
                        $wallet = $hasapay->fetchWalletId($account->token, $account->network);

                        $estimate = $hasapay->estimateGasFee(
                            $wallet['token'],
                            $wallet['chain'],
                            $wallet['network_name'],
                            removeCommas($request->amount)
                        );

                        if ($estimate['success'] == true) {
                            $flat = (float)$account->crypto_wallet_payout_fc + collect(json_decode($account->crypto_wallet_payout_agents, true) ?? [])->sum('rev_fc');
                            $percent = (float)$account->crypto_wallet_payout_pc + collect(json_decode($account->crypto_wallet_payout_agents, true) ?? [])->sum('rev_pc');
                            $charge = [
                                'gas_fee' => $estimate['data']['total_fee']['amount'],
                                'azora_charge' => ($request->amount * $percent / 100) + $flat,
                                'total' => (($request->amount * $percent / 100) + $flat) + $estimate['data']['total_fee']['amount'],
                            ];

                            if ($account->amount < ($request->amount + $charge['total']) && $this->mode == 'live') {
                                $apiresponse = ['message' => __('Insufficient Balance'), 'status' => 'failed', 'data' => null];
                                $this->logError(402, $apiresponse);
                                return response()->json($apiresponse, 402);
                            }

                            if ($request->amount < $charge['total'] && $this->mode == 'live') {
                                $apiresponse = ['message' => __('Charge must be greater than amount'), 'status' => 'failed', 'data' => null];
                                $this->logError(403, $apiresponse);
                                return response()->json($apiresponse, 403);
                            }

                            if ($this->mode == 'live') {
                                logBalance($account->id, ($request->amount + $charge['total']), 'debit', null, 'amount', true);
                            }

                            $balance_before = $account->amount;
                            if ($this->mode == 'live') {
                                $balance_after = $account->amount - ($request->amount + $charge['total']);
                            } else {
                                $balance_after = $account->amount;
                            }

                            $agents = $account?->crypto_wallet_payout_agents;

                            $trx = Transactions::create([
                                'user_id' => $this->client->user_id,
                                'business_id' => $this->client->reference,
                                'amount' => $request->amount,
                                'charge' => $charge['total'],
                                'ref_id' => Str::uuid(),
                                'trx_type' => 'debit',
                                'type' => 'crypto_payout',
                                'status' => 'pending',
                                'mode' => $this->mode,
                                'currency' => $account->token,
                                'balance_before' => $balance_before,
                                'balance_after' => $balance_after,
                                'crypto_wallet_id' => $account->id,
                                'external_reference' => $request->external_reference,
                                'wallet_address' => $request->to_address,
                                'agents' => $agents,
                            ]);

                            $apiresponse = ['message' => __('Processing withdrawal'), 'status' => 'success', 'data' => new TransactionResource($trx)];
                            $this->logError(200, $apiresponse);
                            return response()->json($apiresponse, 200);
                        } else {
                            $msg = $estimate['error'];
                            $apiresponse = ['message' => $msg, 'errors' => ['to_address' => [$msg]], 'status' => 'failed', 'data' => null];
                            $this->logError(422, $apiresponse);
                            return response()->json($apiresponse, 422);
                        }
                    } else {
                        $apiresponse = ['message' => __('Address not found'), 'status' => 'failed', 'data' => null];
                        $this->logError(404, $apiresponse);
                        return response()->json($apiresponse, 404);
                    }
                }, 3);
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' =>  __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            } finally {
                $lock->release();
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function transactions(Request $request, $reference = null)
    {
        $limit = $request->limit;
        $day = $request->day;
        $this->verifyToken($request);
        if ($this->access == true) {
            try {
                $this->ipCheck();
                if ($this->security_check) {
                    return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
                }
                if ($reference != null) {
                    if (Transactions::whereMode($this->mode)->whereRefId($reference)->whereIn('type', ['crypto_deposit', 'crypto_payout'])->exists()) {
                        $apiresponse = ['message' => __('Transaction details'), 'status' => 'success', 'data' => new TransactionResource(Transactions::whereMode($this->mode)->whereRefId($reference)->whereIn('type', ['crypto_deposit', 'crypto_payout'])->first())];
                        $this->logError(200, $apiresponse);
                        return response()->json($apiresponse, 200);
                    } else {
                        $apiresponse = ['message' => __('Transaction not found'), 'status' => 'failed', 'data' => null];
                        $this->logError(404, $apiresponse);
                        return response()->json($apiresponse, 404);
                    }
                } else {
                    $apiresponse = TransactionResource::collection(Transactions::whereMode($this->mode)->whereIn('type', ['crypto_deposit', 'crypto_payout'])->latest()
                        ->when($day != null, fn($query) => $query->whereDate('created_at', '=', \Carbon\Carbon::parse($day)))
                        ->when($request->page == 'all', fn($query) => $query->get(), fn($query) => $query->paginate($limit ?? 20)));
                    $this->logError(200, (array)$apiresponse);
                    return $apiresponse;
                }
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' =>  __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }
}
