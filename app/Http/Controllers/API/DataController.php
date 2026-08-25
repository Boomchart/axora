<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use App\Models\{Settings, Transactions, CountryReg, DataProvider};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\ClientAuthenticate;
use Illuminate\Support\Facades\DB;
use Propaganistas\LaravelPhone\PhoneNumber;

class DataController extends Controller
{
    use ClientAuthenticate;
    public mixed $settings;
    public $bulkErrors = [];

    public function __construct()
    {
        $this->settings = Settings::find(1);
    }

    public function operators(Request $request, string $operator)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            $this->ipCheck();
            if ($this->security_check) {
                return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
            }
            if (DataProvider::whereId($operator)->exists()) {
                $resource = DataProvider::whereId($operator)->first();
                $apiresponse = ['message' => __('Network Operator details'), 'status' => 'success', 'data' => new DataResource($resource, $this->client)];
                $this->logError(200, $apiresponse);
                return response()->json($apiresponse, 200);
            } else {
                $apiresponse = ['message' => __('Network Operator not found'), 'status' => 'failed', 'data' => null];
                $this->logError(404, $apiresponse);
                return response()->json($apiresponse, 404);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function operatorsByCountry(Request $request, string $country)
    {
        $limit = $request->limit;
        $this->verifyToken($request);
        $country = strtoupper($country);
        if ($this->access == true) {
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
            $resource = DataProvider::whereIso2($country)->orderBy('title', 'asc')
                ->when($request->page == 'all', function ($query) {
                    return $query->get();
                }, function ($query) use ($limit) {
                    return $query->when($limit !== null && is_int((int) $limit), function ($query) use ($limit) {
                        return $query->paginate($limit);
                    }, function ($query) {
                        return $query->paginate(20);
                    });
                });
            $apiresponse = ['message' => __('Operators'), 'status' => 'success', 'data' => DataResource::collection($resource)->map(fn($resource) => new DataResource($resource, $this->client))];
            $this->logError(200, (array) $apiresponse);
            return $apiresponse;
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function numberLookup(Request $request)
    {
        $this->verifyToken($request);
        if ($this->access == true) {

            $this->ipCheck();
            if ($this->security_check) {
                return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
            }
            $validator = Validator::make($request->all(), [
                'operator_id' => ['required'],
                'phone_code' => ['required', 'string', 'max:2'],
                'phone' => ['required_with:phone_code', 'nullable'],
            ], [
                'phone.phone' => __('Invalid Phone number'),
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
                    $airtime = DataProvider::whereStatus(1)->whereId($request->operator_id)->first();
                    if ($airtime) {
                        $phone_code = strtoupper($request->phone_code);
                        try {
                            $phone = PhoneNumber::make($request->phone, strtoupper($request->phone_code));
                        } catch (\Exception $e) {
                            $msg = __('Invalid phone number, phone number does not match phone_code provided');
                            $apiresponse = ['message' => $msg, 'errors' => ['phone' => [$msg]], 'status' => 'failed', 'data' => null];
                            $this->logError(422, $apiresponse);
                            return response()->json($apiresponse, 422);
                        }
                        if ($phone_code != $airtime->iso2) {
                            $msg = __('Phone number not supported by operator ');
                            $apiresponse = ['message' => $msg, 'errors' => ['phone' => [$msg]], 'status' => 'failed', 'data' => null];
                            $this->logError(422, $apiresponse);
                            return response()->json($apiresponse, 422);
                        } else {
                            $apiresponse = ['message' => __('Network Operator details'), 'status' => 'success', 'data' => new DataResource($airtime, $this->client)];
                            $this->logError(200, $apiresponse);
                            return response()->json($apiresponse, 200);
                        }
                    } else {
                        $apiresponse = ['message' => __('Data Operator not found'), 'status' => 'failed', 'data' => null];
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

    public function quote(Request $request)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            try {
                $this->ipCheck();
                if ($this->security_check) {
                    return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
                }

                $validator = Validator::make($request->all(), [
                    'operator_id' => ['required'],
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

                $airtime = DataProvider::whereStatus(1)->whereId($request->operator_id)->first();
                if ($airtime) {
                    $denominations = collect(json_decode($airtime->denominations, true))->map(fn($data) => $data['amount'])->toArray();
                    if (!in_array($request->amount, $denominations)) {
                        $msg = __('Amount must be between denominations of ') . implode(', ', $denominations);
                        $apiresponse = ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null];
                        $this->logError(422, $apiresponse);
                        return response()->json($apiresponse, 422);
                    }
                    if ($request->amount < min($denominations)) {
                        $msg = __('Amount is lower than minimum amount of ') . min($denominations);
                        $apiresponse = ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null];
                        $this->logError(422, $apiresponse);
                        return response()->json($apiresponse, 422);
                    }
                    if ($request->amount > max($denominations)) {
                        $msg = __('Amount is higher than maximum amount of ') . max($denominations);
                        $apiresponse = ['message' => $msg, 'errors' => ['amount' => [$msg]], 'status' => 'failed', 'data' => null];
                        $this->logError(422, $apiresponse);
                        return response()->json($apiresponse, 422);
                    }
                } else {
                    $apiresponse = ['message' => __('Data operator not found'), 'status' => 'failed', 'data' => null];
                    $this->logError(404, $apiresponse);
                    return response()->json($apiresponse, 404);
                }

                $amount = $request->amount * $airtime->rate;

                $our_flat_fee = $this->client->airtime_issuing_fc + collect(json_decode($this->client->airtime_issuing_agents, true) ?? [])->sum('rev_fc');
                $our_percent_fee = $this->client->airtime_issuing_pc + collect(json_decode($this->client->airtime_issuing_agents, true) ?? [])->sum('rev_pc');

                //our charge must always end up in usd
                //vendor charge must always end up in usd
                if ($airtime->charge_phase == 'before_conversion') {
                    $our_charge = (float) calculateFee(removeCommas($amount / $airtime->rate), 'both', $our_flat_fee, $our_percent_fee, 0) * $airtime->rate;
                    $vendor_charge = (float) calculateFee(
                        removeCommas($amount / $airtime->rate),
                        'both',
                        ($airtime->tier_pricing == 0) ? $airtime->issuing_fc : tierPricing($amount / $airtime->rate, $airtime->issuing_tiers)['flat'],
                        ($airtime->tier_pricing == 0) ? $airtime->issuing_pc : tierPricing($amount / $airtime->rate, $airtime->issuing_tiers)['percent'],
                        0
                    ) * $airtime->rate;
                } else {
                    $our_charge = (float) calculateFee(removeCommas($amount), 'both', $our_flat_fee, $our_percent_fee, 0);
                    $vendor_charge = (float) calculateFee(
                        removeCommas($amount),
                        'both',
                        ($airtime->tier_pricing == 0) ? $airtime->issuing_fc : tierPricing($amount, $airtime->issuing_tiers)['flat'],
                        ($airtime->tier_pricing == 0) ? $airtime->issuing_pc : tierPricing($amount, $airtime->issuing_tiers)['percent'],
                        0
                    );
                }

                $item = [
                    'id' => $airtime->id,
                    'amount' => $request->amount,
                    'exchange_rate' => $airtime->rate,
                    'converted_to_usd' => $request->amount * $airtime->rate,
                    'charge' => $our_charge + $vendor_charge,
                    'total' => $amount + $vendor_charge + $our_charge,
                    'operator' => new DataResource($airtime, $this->client)
                ];

                $apiresponse = ['message' => __('Data Quote calculated'), 'status' => 'success', 'data' => $item];
                $this->logError(200, $apiresponse);
                return response()->json($apiresponse, 200);
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' =>  __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
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
        $operatorIds = $dataCollection->pluck('operator_id')->filter()->unique()->all();

        $operators = DataProvider::whereStatus(1)->whereIn('id', $operatorIds)->get()->keyBy('id');

        $issuingAgents = json_decode($this->client->airtime_issuing_agents, true) ?? [];
        $agentFlatFee = collect($issuingAgents)->sum('rev_fc');
        $agentPercentFee = collect($issuingAgents)->sum('rev_pc');
        $ourFlatFee = $this->client->airtime_issuing_fc + $agentFlatFee;
        $ourPercentFee = $this->client->airtime_issuing_pc + $agentPercentFee;

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
                    'operator_id' => ['required'],
                    'amount' => ['required', 'numeric'],
                    'phone_code' => ['required', 'string', 'max:2'],
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

                $operator = $operators[$value['operator_id']] ?? null;
                if (!$operator) {
                    $this->updateError($rowKey, ['message' => __('Operator not found'), 'status' => 'failed', 'data' => null], 404);
                    $hasErrors = true;
                    continue;
                }

                $phone_code = strtoupper($value['phone_code']);
                try {
                    $value['phone'] = PhoneNumber::make($value['phone'], strtoupper($value['phone_code']));
                } catch (\Exception $e) {
                    $msg = __('Invalid phone number, phone number does not match phone_code provided');
                    $this->updateError($rowKey, ['message' => $msg, 'errors' => ['phone' => [$msg]], 'status' => 'failed', 'data' => null], 422);
                    $hasErrors = true;
                    continue;
                }
                if ($phone_code != $operator->iso2) {
                    $msg = __('Phone number not supported by operator ');
                    $this->updateError($rowKey, ['message' => $msg, 'errors' => ['phone' => [$msg]], 'status' => 'failed', 'data' => null], 422);
                    $hasErrors = true;
                    continue;
                }

                $denominations = collect(json_decode($operator->denominations, true))->map(fn($d) => $d['amount'])->toArray();
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

                $convertedAmount = $value['amount'] * $operator->rate;

                if ($operator->charge_phase == 'before_conversion') {
                    $base = removeCommas($convertedAmount / $operator->rate);
                    if ($operator->tier_pricing == 0) {
                        $vendorFlat = $operator->issuing_fc;
                        $vendorPercent = $operator->issuing_pc;
                    } else {
                        $tier = tierPricing($base, $operator->issuing_tiers);
                        $vendorFlat = $tier['flat'];
                        $vendorPercent = $tier['percent'];
                    }
                    $ourCharge = (float) calculateFee($base, 'both', $ourFlatFee, $ourPercentFee) * $operator->rate;
                    $agentCharge = (float) calculateFee($base, 'both', $agentFlatFee, $agentPercentFee) * $operator->rate;
                    $vendorCharge = (float) calculateFee($base, 'both', $vendorFlat, $vendorPercent) * $operator->rate;
                } else {
                    $base = removeCommas($convertedAmount);
                    if ($operator->tier_pricing == 0) {
                        $vendorFlat = $operator->issuing_fc;
                        $vendorPercent = $operator->issuing_pc;
                    } else {
                        $tier = tierPricing($base, $operator->issuing_tiers);
                        $vendorFlat = $tier['flat'];
                        $vendorPercent = $tier['percent'];
                    }
                    $ourCharge = (float) calculateFee($base, 'both', $ourFlatFee, $ourPercentFee);
                    $agentCharge = (float) calculateFee($base, 'both', $agentFlatFee, $agentPercentFee);
                    $vendorCharge = (float) calculateFee($base, 'both', $vendorFlat, $vendorPercent);
                }

                $itemTotal = ($convertedAmount + $vendorCharge + $ourCharge);
                $itemFinalCharge = ($vendorCharge + $ourCharge);

                $items[] = [
                    'value' => $value,
                    'operator' => $operator,
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
                    'type' => 'data_purchase',
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
                    $operator = $item['operator'];
                    $vendorId = $operator['provider'] == 'reloadly' ? $operator['reloadly_id'] : $operator['redboxx_id'];
                    $rowBase = [
                        'user_id' => $this->client->user_id,
                        'business_id' => $this->client->reference,
                        'amount' => $value['amount'],
                        'rev_share' => $item['agent_charge'],
                        'vendor_share' => $item['vendor_charge'],
                        'profit' => $item['our_charge'] - $item['agent_charge'],
                        'discount' => $value['amount'] * $operator->rate * $operator->discount,
                        'status' => 'pending',
                        'trx_id' => $trx->id,
                        'currency' => $operator->currency,
                        'rate' => $operator->rate,
                        'provider' => $operator->provider,
                        'vendor_id' => $vendorId,
                        'mode' => $this->mode,
                        'agents' => $this->client->issuing_agents,
                        'operator_id' => $operator->id,
                        'operator_name' => $operator->title . ' - ' . (collect(json_decode($operator->denominations, true))->where('amount', $value['amount'])->first()['plan']),
                        'operator_currency' => $operator->currency,
                        'operator_country' => $operator->iso2,
                        'phone' => $value['phone'],
                        'phone_code' => $value['phone_code'],
                        'external_reference' => $value['external_reference'],
                        'type' => 'data',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    for ($i = 1; $i <= 1; $i++) {
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
                    if (Transactions::whereBusinessId($this->client->reference)->whereMode($this->mode)->whereRefId($reference)->whereType('data_purchase')->exists()) {
                        $apiresponse = ['message' => __('Transaction details'), 'status' => 'success', 'data' => new TransactionResource(Transactions::whereBusinessId($this->client->reference)->whereMode($this->mode)->whereRefId($reference)->whereType('data_purchase')->first())];
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
                        'data' => TransactionResource::collection(Transactions::whereBusinessId($this->client->reference)->whereMode($this->mode)->whereType('data_purchase')->latest()
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
