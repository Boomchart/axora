<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use App\Models\{Settings, Transactions, CountryReg, BuyCard};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\ClientAuthenticate;
use Illuminate\Support\Facades\DB;
use Propaganistas\LaravelPhone\PhoneNumber;

class GiftcardController extends Controller
{
    use ClientAuthenticate;
    public mixed $settings;
    public $bulkErrors = [];

    public function __construct()
    {
        $this->settings = Settings::find(1);
    }

    public function cards(Request $request, string $card)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            $this->ipCheck();
            if ($this->security_check) {
                return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
            }

            if (BuyCard::whereId($card)->exists()) {
                $resource = BuyCard::whereId($card)->first();
                $apiresponse = ['message' => __('Card details'), 'status' => 'success', 'data' => new CardResource($resource, $this->client)];
                $this->logError(200, $apiresponse);
                return response()->json($apiresponse, 200);
            } else {
                $apiresponse = ['message' => __('Card not found'), 'status' => 'failed', 'data' => null];
                $this->logError(404, $apiresponse);
                return response()->json($apiresponse, 404);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function cardsByCountry(Request $request, string $country)
    {
        $limit = $request->limit;
        $this->verifyToken($request);
        $country = strtoupper($country);
        if ($this->access == true) {
            try {
                $this->ipCheck();
                if ($this->security_check) {
                    return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
                }
                if ($country == null) {
                    $apiresponse = [
                        'message' => __('country iso2 is required'),
                        'errors' => ['country' => [__('country iso2 is required')]],
                        'status' => 'failed',
                        'data' => null,
                    ];
                    $this->logError(422, $apiresponse);
                    return response()->json($apiresponse, 422);
                } else {
                    if (!CountryReg::whereStatus(1)->whereIso2($country)->exists()) {
                        $apiresponse = ['message' => __('Country not found'), 'status' => 'failed', 'data' => null];
                        $this->logError(404, $apiresponse);
                        return response()->json($apiresponse, 404);
                    }
                }

                $resource = BuyCard::whereIso2($country)->orderBy('title', 'asc')
                    ->when($request->page == 'all', function ($query) {
                        return $query->get();
                    }, function ($query) use ($limit) {
                        return $query->when($limit !== null && is_int((int) $limit), function ($query) use ($limit) {
                            return $query->paginate($limit);
                        }, function ($query) {
                            return $query->paginate(20);
                        });
                    });
                $apiresponse = ['message' => __('Cards'), 'status' => 'success', 'data' => CardResource::collection($resource)->map(fn($resource) => new CardResource($resource, $this->client))];
                $this->logError(200, (array) $apiresponse);
                return $apiresponse;
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' =>  __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function quote(Request $request)
    {
        $this->verifyToken($request);
        if ($this->access != true) {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }

        try {
            $this->ipCheck();
            if ($this->security_check) {
                return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
            }

            $validator = Validator::make($request->all(), [
                'card_id' => ['required'],
                'amount' => ['required', 'numeric'],
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

            $card = BuyCard::whereStatus(1)->whereId($request->card_id)->first();
            if (!$card) {
                $apiresponse = ['message' => __('Card not found'), 'status' => 'failed', 'data' => null];
                $this->logError(404, $apiresponse);
                return response()->json($apiresponse, 404);
            }

            $amount = $request->amount;

            if ($card->only_denominations) {
                $denominations = array_column(json_decode($card->denominations, true) ?? [], 'amount');
                $minDen = min($denominations);
                $maxDen = max($denominations);

                if (!in_array($amount, $denominations)) {
                    $msg = __('Amount must be between denominations of ') . implode(', ', $denominations);
                    $apiresponse = ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null];
                    $this->logError(422, $apiresponse);
                    return response()->json($apiresponse, 422);
                }
                if ($amount < $minDen) {
                    $msg = __('Amount is lower than minimum amount of ') . $minDen;
                    $apiresponse = ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null];
                    $this->logError(422, $apiresponse);
                    return response()->json($apiresponse, 422);
                }
                if ($amount > $maxDen) {
                    $msg = __('Amount is higher than maximum amount of ') . $maxDen;
                    $apiresponse = ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null];
                    $this->logError(422, $apiresponse);
                    return response()->json($apiresponse, 422);
                }
            } else {
                if ($amount < $card->min) {
                    $msg = __('Amount is lower than minimum amount of ') . $card->min;
                    $apiresponse = ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null];
                    $this->logError(422, $apiresponse);
                    return response()->json($apiresponse, 422);
                }
                if ($amount > $card->max) {
                    $msg = __('Amount is higher than maximum amount of ') . $card->max;
                    $apiresponse = ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null];
                    $this->logError(422, $apiresponse);
                    return response()->json($apiresponse, 422);
                }
            }

            $convertedAmount = $amount * $card->rate;

            $issuingAgents = json_decode($this->client->issuing_agents, true) ?? [];
            $agentsCollection = collect($issuingAgents);
            $ourFlatFee = $this->client->issuing_fc + $agentsCollection->sum('rev_fc');
            $ourPercentFee = $this->client->issuing_pc + $agentsCollection->sum('rev_pc');

            //our charge must always end up in usd
            //vendor charge must always end up in usd
            if ($card->charge_phase == 'before_conversion') {
                $base = removeCommas($amount);
                $rateMultiplier = $card->rate;
            } else {
                $base = removeCommas($convertedAmount);
                $rateMultiplier = 1;
            }

            if ($card->tier_pricing == 0) {
                $vendorFlat = $card->issuing_fc;
                $vendorPercent = $card->issuing_pc;
            } else {
                $tier = tierPricing($base, $card->issuing_tiers);
                $vendorFlat = $tier['flat'];
                $vendorPercent = $tier['percent'];
            }

            $ourCharge = (float) calculateFee($base, 'both', $ourFlatFee, $ourPercentFee) * $rateMultiplier;
            $vendorCharge = (float) calculateFee($base, 'both', $vendorFlat, $vendorPercent) * $rateMultiplier;

            $item = [
                'id' => $card->id,
                'amount' => $amount,
                'exchange_rate' => $card->rate,
                'converted_to_usd' => $convertedAmount,
                'charge' => $ourCharge + $vendorCharge,
                'total' => $convertedAmount + $vendorCharge + $ourCharge,
                'card' => new CardResource($card, $this->client)
            ];

            $apiresponse = ['message' => __('Gift Card Quote calculated'), 'status' => 'success', 'data' => $item];
            $this->logError(200, $apiresponse);
            return response()->json($apiresponse, 200);
        } catch (\Exception $e) {
            $this->logError(500, $e->getMessage());
            return response()->json(['message' =>  __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
        }
    }

    public function updateError(string $type, array $message, string $status)
    {
        if (!isset($this->bulkErrors[$type])) {
            $this->bulkErrors[$type] = [];
        }

        $this->bulkErrors[$type][] = [
            'message' => $message,
            'status' => $status,
        ];
    }

    public function order(Request $request)
    {
        $this->verifyToken($request);
        if ($this->access != true) {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }

        $this->ipCheck();
        if ($this->security_check) {
            return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
        }

        $validator = Validator::make($request->all(), ['data' => ['required', 'array']]);
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

        $data = $request->input('data');

        if (count($data) > 100) {
            $msg = __('Maximum 100 recipients allowed in a single request');
            $apiresponse = ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null];
            $this->logError(422, $apiresponse);
            return response()->json($apiresponse, 422);
        }

        $dataCollection = collect($data);
        $externalReferences = $dataCollection->pluck('external_reference')->filter()->unique()->all();
        $cardIds = $dataCollection->pluck('card_id')->filter()->unique()->all();

        $cards = BuyCard::whereStatus(1)->whereIn('id', $cardIds)->get()->keyBy('id');

        $issuingAgents = json_decode($this->client->issuing_agents, true) ?? [];
        $agentFlatFee = collect($issuingAgents)->sum('rev_fc');
        $agentPercentFee = collect($issuingAgents)->sum('rev_pc');
        $ourFlatFee = $this->client->issuing_fc + $agentFlatFee;
        $ourPercentFee = $this->client->issuing_pc + $agentPercentFee;

        $existingPovs = DB::table('orders')
            ->whereBusinessId($this->client->reference)
            ->whereIn('external_reference', $externalReferences)
            ->where('mode', $this->mode)
            ->pluck('external_reference')
            ->all();
        $existingPovsSet = array_flip($existingPovs);

        $lock = cache()->lock('request_lock_' . $this->client->reference, 3);
        if (!$lock->get()) {
            $apiresponse = ['message' => __('Please wait a moment before trying again'), 'status' => 'failed', 'data' => null];
            $this->logError(429, $apiresponse);
            return response()->json($apiresponse, 429);
        }

        $hasErrors = false;
        $balance = $this->client->user->getFirstBalance();

        try {
            $items = [];
            $totalSum = 0;
            $finalChargeSum = 0;
            $seenRefs = [];

            foreach ($data as $key => $value) {
                $rowKey = $value['external_reference'] ?? $key;

                $rowValidator = Validator::make($value, [
                    'external_reference' => ['required', 'string', 'max:36'],
                    'card_id' => ['required'],
                    'name' => ['required', 'string', 'max:255'],
                    'amount' => ['required', 'numeric'],
                    'quantity' => ['required', 'integer', 'min:1', 'max:20'],
                    'email' => ['required', 'email:dns,rfc', 'max:255'],
                    'phone_code' => ['required_with:phone', 'nullable', 'string', 'max:2'],
                    'phone' => ['required_with:phone_code', 'nullable', 'phone:' . strtoupper($value['phone_code'] ?? '')],
                ], [
                    'phone.phone' => __('Invalid Phone number'),
                ]);

                if ($rowValidator->fails()) {
                    $this->updateError($rowKey, $rowValidator->errors()->toArray(), 422);
                    $hasErrors = true;
                    continue;
                }

                $ref = $value['external_reference'];

                if (isset($seenRefs[$ref])) {
                    $msg = __('Duplicate external_reference: ') . $ref;
                    $this->updateError($ref, ['message' => $msg, 'errors' => ['external_reference' => [$msg]], 'status' => 'failed', 'data' => null], 422);
                    $hasErrors = true;
                    continue;
                }
                $seenRefs[$ref] = true;

                if (isset($existingPovsSet[$ref])) {
                    $this->updateError($ref, __('Invalid external_reference, already used in a previous transaction'), 404);
                    $hasErrors = true;
                    continue;
                }

                $card = $cards[$value['card_id']] ?? null;
                if (!$card) {
                    $this->updateError($rowKey, ['message' => __('Card not found'), 'status' => 'failed', 'data' => null], 404);
                    $hasErrors = true;
                    continue;
                }

                try {
                    $value['phone'] = PhoneNumber::make($value['phone'], strtoupper($value['phone_code']));
                } catch (\Exception $e) {
                    $msg = __('Invalid phone number, phone number does not match phone_code provided');
                    $this->updateError($rowKey, ['message' => $msg, 'errors' => ['phone' => [$msg]], 'status' => 'failed', 'data' => null], 422);
                    $hasErrors = true;
                    continue;
                }

                if ($card->only_denominations) {
                    $denominations = json_decode($card->denominations, true);
                    $minDen = min($denominations);
                    $maxDen = max($denominations);

                    if (!in_array($value['amount'], $denominations)) {
                        $msg = __('Amount must be between denominations of ') . implode(', ', $denominations);
                        $this->updateError($rowKey, ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null], 422);
                        $hasErrors = true;
                        continue;
                    }
                    if ($value['amount'] < $minDen) {
                        $msg = __('Amount is lower than minimum amount of ') . $minDen;
                        $this->updateError($rowKey, ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null], 422);
                        $hasErrors = true;
                        continue;
                    }
                    if ($value['amount'] > $maxDen) {
                        $msg = __('Amount is higher than maximum amount of ') . $maxDen;
                        $this->updateError($rowKey, ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null], 422);
                        $hasErrors = true;
                        continue;
                    }
                } else {
                    if ($value['amount'] < $card->min) {
                        $msg = __('Amount is lower than minimum amount of ') . $card->min;
                        $this->updateError($rowKey, ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null], 422);
                        $hasErrors = true;
                        continue;
                    }
                    if ($value['amount'] > $card->max) {
                        $msg = __('Amount is higher than maximum amount of ') . $card->max;
                        $this->updateError($rowKey, ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null], 422);
                        $hasErrors = true;
                        continue;
                    }
                }

                $convertedAmount = $value['amount'] * $card->rate;

                if ($card->charge_phase == 'before_conversion') {
                    $base = removeCommas($convertedAmount / $card->rate);
                    if ($card->tier_pricing == 0) {
                        $vendorFlat = $card->issuing_fc;
                        $vendorPercent = $card->issuing_pc;
                    } else {
                        $tier = tierPricing($base, $card->issuing_tiers);
                        $vendorFlat = $tier['flat'];
                        $vendorPercent = $tier['percent'];
                    }
                    $ourCharge = (float) calculateFee($base, 'both', $ourFlatFee, $ourPercentFee) * $card->rate;
                    $agentCharge = (float) calculateFee($base, 'both', $agentFlatFee, $agentPercentFee) * $card->rate;
                    $vendorCharge = (float) calculateFee($base, 'both', $vendorFlat, $vendorPercent) * $card->rate;
                } else {
                    $base = removeCommas($convertedAmount);
                    if ($card->tier_pricing == 0) {
                        $vendorFlat = $card->issuing_fc;
                        $vendorPercent = $card->issuing_pc;
                    } else {
                        $tier = tierPricing($base, $card->issuing_tiers);
                        $vendorFlat = $tier['flat'];
                        $vendorPercent = $tier['percent'];
                    }
                    $ourCharge = (float) calculateFee($base, 'both', $ourFlatFee, $ourPercentFee);
                    $agentCharge = (float) calculateFee($base, 'both', $agentFlatFee, $agentPercentFee);
                    $vendorCharge = (float) calculateFee($base, 'both', $vendorFlat, $vendorPercent);
                }

                $itemTotal = ($convertedAmount + $vendorCharge + $ourCharge) * $value['quantity'];
                $itemFinalCharge = ($vendorCharge + $ourCharge) * $value['quantity'];

                $items[] = [
                    'value' => $value,
                    'card' => $card,
                    'our_charge' => $ourCharge,
                    'agent_charge' => $agentCharge,
                    'vendor_charge' => $vendorCharge,
                ];

                $totalSum += $itemTotal;
                $finalChargeSum += $itemFinalCharge;
            }

            if ($hasErrors) {
                $this->logError(400, $this->bulkErrors);
                return response()->json(['message' => __('An error occured'), 'status' => 'failed', 'data' => $this->bulkErrors], 400);
            }

            if ($balance->amount < $totalSum && $this->mode == 'live') {
                $apiresponse = ['message' => __('Insufficient Balance'), 'status' => 'failed', 'data' => null];
                $this->logError(402, $apiresponse);
                return response()->json($apiresponse, 402);
            }

            return DB::transaction(function () use ($items, $balance, $totalSum, $finalChargeSum) {
                // Re-read the balance under a row lock inside the transaction. The cache
                // lock above can expire (3s TTL) while the Hasapay calls run, so this is
                // the authoritative guard against concurrent orders overdrawing the balance.
                if ($this->mode == 'live') {
                    $balance = \App\Models\Balance::disableCache()->whereKey($balance->id)->lockForUpdate()->first();

                    if (! $balance || $balance->amount < $totalSum) {
                        throw new \RuntimeException(__('Insufficient Balance'));
                    }
                }

                $balance_before = $balance->amount;
                if ($this->mode == 'live') {
                    $balance_after = $balance->amount - $totalSum;
                    $balance->decrement('amount', $totalSum);
                } else {
                    $balance_after = $balance->amount;
                }

                $trx = Transactions::create([
                    'user_id' => $this->client->user_id,
                    'business_id' => $this->client->reference,
                    'amount' => $totalSum - $finalChargeSum,
                    'charge' => $finalChargeSum,
                    'ref_id' => Str::uuid(),
                    'trx_type' => 'debit',
                    'type' => 'giftcard_purchase',
                    'status' => 'success',
                    'mode' => $this->mode,
                    'currency' => $this->settings->real->currency,
                    'balance_before' => $balance_before,
                    'balance_after' => $balance_after,
                    'wallet_id' => $balance->id,
                ]);

                $now = now();
                $rows = [];
                foreach ($items as $item) {
                    $value = $item['value'];
                    $card = $item['card'];
                    $vendorId = $card['provider'] == 'reloadly' ? $card['reloadly_id'] : $card['redboxx_id'];
                    $rowBase = [
                        'user_id' => $this->client->user_id,
                        'business_id' => $this->client->reference,
                        'amount' => $value['amount'],
                        'rev_share' => $item['agent_charge'],
                        'vendor_share' => $item['vendor_charge'],
                        'profit' => $item['our_charge'] - $item['agent_charge'],
                        'discount' => ($value['amount'] * $card->rate) * $card->discount,
                        'status' => 'pending',
                        'trx_id' => $trx->id,
                        'card_id' => $card->id,
                        'currency' => $card->currency,
                        'rate' => $card->rate,
                        'provider' => $card->provider,
                        'vendor_id' => $vendorId,
                        'mode' => $this->mode,
                        'agents' => $this->client->issuing_agents,
                        'card_name' => $card->title,
                        'card_currency' => $card->currency,
                        'card_country' => $card->iso2,
                        'name' => $value['name'],
                        'email' => $value['email'],
                        'phone' => $value['phone'],
                        'phone_code' => $value['phone_code'],
                        'external_reference' => $value['external_reference'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    for ($i = 1; $i <= $value['quantity']; $i++) {
                        $rows[] = ['id' => (string) Str::uuid()] + $rowBase;
                    }
                }
                \App\Models\Orders::insert($rows);

                $apiresponse = ['message' => __('Payment successful, processing order'), 'status' => 'success', 'data' => new TransactionResource($trx)];
                $this->logError(200, $apiresponse);
                return response()->json($apiresponse, 200);
            }, 3);
        } catch (\Exception $e) {
            $this->logError(500, $e->getMessage());
            return response()->json(['message' => __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
        } finally {
            $lock->release();
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
                    if (Transactions::whereBusinessId($this->client->reference)->whereMode($this->mode)->whereRefId($reference)->whereType('giftcard_purchase')->exists()) {
                        $apiresponse = ['message' => __('Transaction details'), 'status' => 'success', 'data' => new TransactionResource(Transactions::whereBusinessId($this->client->reference)->whereMode($this->mode)->whereRefId($reference)->whereType('giftcard_purchase')->first())];
                        $this->logError(200, $apiresponse);
                        return response()->json($apiresponse, 200);
                    } else {
                        $apiresponse = ['message' => __('Transaction not found'), 'status' => 'failed', 'data' => null];
                        $this->logError(404, $apiresponse);
                        return response()->json($apiresponse, 404);
                    }
                } else {
                    $apiresponse = [
                        'message' => __('Transactions'),
                        'status' => 'success',
                        'data' => TransactionResource::collection(Transactions::whereBusinessId($this->client->reference)->whereMode($this->mode)->whereType('giftcard_purchase')->latest()
                            ->when($day != null, fn($query) => $query->whereDate('created_at', '=', \Carbon\Carbon::parse($day)))
                            ->when($request->page == 'all', fn($query) => $query->get(), fn($query) => $query->paginate($limit ?? 20)))
                    ];
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
