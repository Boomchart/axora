<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Http\Resources\CardCountryResource;
use App\Http\Resources\TransactionResource;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Transactions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Jobs\SendEmail;
use App\Traits\ClientAuthenticate;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class APIController extends Controller
{
    use ClientAuthenticate;
    public mixed $settings;

    public function __construct()
    {
        $this->settings = Settings::find(1);
    }

    public function balance(Request $request)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            try {
                $this->ipCheck();
                $this->logError(200);
                return response()->json([
                    'message' => __('Account Balance'),
                    'status' => 'success',
                    'data' => [
                        'amount' => number_format($this->client->user->getBalance($this->settings->currency)->amount * 100, 2, '.', ''),
                        'currency' => $this->settings->real->currency
                    ]
                ], 200);
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' => __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function countries(Request $request, $return = true)
    {
        $limit = $request->limit;
        $this->verifyToken($request);
        if ($this->access == true) {
            try {
                $this->ipCheck();
                $cacheKey = 'redboxx_countries';
                if (Cache::has($cacheKey)) {
                    $data = Cache::get($cacheKey);
                } else {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . ($this->mode == 'live' ? config('settings.redboxx_api_key') : config('settings.redboxx_test_api_key')),
                    ])->get(config('settings.redboxx_url') . '/v1/countries');

                    if ($response->successful()) {
                        $data = collect($response->json()['data']);
                        Cache::put($cacheKey, $data, now()->addHours(36));
                    } else {
                        $data = collect();
                    }
                }

                if ($data->isEmpty()) {
                    return response()->json([
                        'message' => __('An error occurred, try again later'),
                        'status'  => 'failed',
                        'data'    => null,
                    ], 500);
                }

                if ($return) {
                    if ($request->page === 'all') {
                        $this->logError(200);
                        return CardCountryResource::collection($data);
                    }

                    $limit = $limit !== null && is_numeric($limit) ? (int) $limit : 20;
                    $page = request()->get('page', 1);
                    $paginated = new LengthAwarePaginator($data->forPage($page, $limit), $data->count(), $limit, $page, ['path' => request()->url(), 'query' => request()->query()]);
                    $this->logError(200);
                    return CardCountryResource::collection($paginated);
                }
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' => __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function cards(Request $request, $country, $card = null)
    {
        $limit = $request->limit;
        $country = strtoupper($country);
        $this->verifyToken($request);
        if ($this->access == true) {
            try {
                $this->ipCheck();
                //Validate Country
                if ($country == null) {
                    $this->logError(403);
                    return response()->json(['message' => __('Country iso2 is required'), 'status' => 'failed', 'data' => null], 403);
                } else {
                    //Build countries cache
                    $this->countries($request, false);
                    $countries = collect(Cache::get('redboxx_countries'));
                    if ($countries->where('iso2', strtoupper($country))->first() == null) {
                        $this->logError(404);
                        return response()->json(['message' => __('Country not found'), 'status' => 'failed', 'data' => null], 404);
                    }
                }

                //Build Card Data Cache

                $cacheKey = 'redboxx_cards-' . $country;
                if (Cache::has($cacheKey)) {
                    $cardData = Cache::get($cacheKey);
                } else {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . ($this->mode == 'live' ? config('settings.redboxx_api_key') : config('settings.redboxx_test_api_key')),
                    ])->get(config('settings.redboxx_url') . '/v1/cards/' . $country);

                    if ($response->successful()) {
                        $cardData = collect($response->json()['data']);
                        Cache::put($cacheKey, $cardData, now()->addHours(36));
                        foreach ($cardData as $buildSingleCache) {
                            $cacheKeySingle = 'redboxx_card-' . $buildSingleCache['id'];
                            Cache::put($cacheKeySingle, $buildSingleCache, now()->addHours(36));
                        }
                    } else {
                        $cardData = collect();
                    }
                }


                if ($card != null) {
                    $fetch = $cardData->where('id', $card)->where('country', $country)->first();
                    if ($fetch) {
                        $cacheKey = 'redboxx_card-' . $fetch['id'];
                        if (Cache::has($cacheKey) == false) {
                            Cache::put($cacheKey, $fetch, now()->addHours(36));
                        }
                        $this->logError(200);
                        return response()->json(['message' => __('Card details'), 'status' => 'success', 'data' => new CardResource($fetch)], 200);
                    } else {
                        $this->logError(404);
                        return response()->json(['message' => __('Card not found'), 'status' => 'failed', 'data' => null], 404);
                    }
                } else {
                    if ($request->page === 'all') {
                        $this->logError(200);
                        return CardResource::collection($cardData);
                    }

                    $limit = $limit !== null && is_numeric($limit) ? (int) $limit : 20;
                    $page = request()->get('page', 1);
                    $paginated = new LengthAwarePaginator($cardData->forPage($page, $limit), $cardData->count(), $limit, $page, ['path' => request()->url(), 'query' => request()->query()]);
                    $this->logError(200);
                    return CardResource::collection($paginated);
                }
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' => __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
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
                $validator = Validator::make($request->all(), [
                    'card_id' => ['required'],
                    'amount' => ['required', 'numeric'],
                ]);

                if ($validator->fails()) {
                    $this->logError(422, $validator->errors());
                    return response()->json(['message' => $validator->errors(), 'status' => 'failed', 'data' => null], 422);
                }

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . ($this->mode == 'live' ? config('settings.redboxx_api_key') : config('settings.redboxx_test_api_key')),
                ])->post(config('settings.redboxx_url') . '/v1/quote', [
                    'card_id' => $request->card_id,
                    'amount' => $request->amount,
                ]);

                if ($response->successful()) {
                    $data = $response->json()['data'];
                    //Calculate our charge
                    $flat = ($this->client->issuing_fc + collect(json_decode($this->client->issuing_agents, true) ?? [])->sum('rev_fc'));
                    $percent = ($this->client->issuing_pc + collect(json_decode($this->client->issuing_agents, true) ?? [])->sum('rev_pc'));

                    $our_charge = ($data['converted_to_usd'] * $percent / 100) + $flat;

                    $item = [
                        'id' => $data['id'],
                        'amount' => $data['amount'],
                        'exchange_rate' => $data['exchange_rate'],
                        'converted_to_usd' => $data['converted_to_usd'],
                        'charge' => $our_charge + $data['charge'],
                        'total' => $data['total'] + $our_charge,
                    ];

                    // return response()->json(['message' => [
                    //     'our_charge' => $our_charge,
                    //     'item' => $item,
                    //     'real_item' => $data
                    // ], 'status' => 'failed', 'data' => null], 402);

                    $this->logError(200);
                    return response()->json(['message' => __('Quote calculated'), 'status' => 'success', 'data' => $item], 200);
                } else {
                    $this->logError($response->status(), $response->json()['message']);
                    return response()->json([
                        'message' => $response->json()['message'] ?? __('An error occurred, try again later'),
                        'status'  => 'failed',
                        'data'    => null,
                    ], $response->status());
                }
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' =>  __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function order(Request $request)
    {
        $this->verifyToken($request);
        if ($this->access == true) {
            try {
                $this->ipCheck();

                $validator = Validator::make($request->all(), [
                    'card_id' => ['required'],
                    'name' => ['required', 'string', 'max:255'],
                    'amount' => ['required', 'numeric'],
                    'quantity' => ['required', 'integer', 'min:1', 'max:10'],
                    'email' => ['required', 'email:dns,rfc', 'max:255'],
                    'phone_code' => ['required', 'string', 'max:2'],
                    'phone' => ['required_with:phone_code', 'nullable', 'phone:' . strtoupper($request->phone_code)],
                ], [
                    'phone.phone' => __('Invalid Phone number'),
                ]);

                if ($validator->fails()) {
                    $this->logError(422, $validator->errors());
                    return response()->json(['message' => $validator->errors(), 'status' => 'failed', 'data' => null], 422);
                }

                $cacheKey = 'redboxx_card-' . $request->card_id;
                if (Cache::has($cacheKey) == false) {
                    $cardData = Cache::get($cacheKey);
                } else {
                    $cardData = Http::withHeaders([
                        'Authorization' => 'Bearer ' . ($this->mode == 'live' ? config('settings.redboxx_api_key') : config('settings.redboxx_test_api_key')),
                    ])->get(config('settings.redboxx_url') . '/v1/fetch-card/' . $request->card_id);
                    if ($cardData->status() != 200) {
                        $this->logError(404, __('Card not found'));
                        return response()->json(['message' => __('Card not found'), 'status' => 'failed', 'data' => null], 404);
                    }
                }

                $card = $cardData->json()['data'];
                $balance = $this->client->user->getFirstBalance();

                $quoteResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . ($this->mode == 'live' ? config('settings.redboxx_api_key') : config('settings.redboxx_test_api_key')),
                ])->post(config('settings.redboxx_url') . '/v1/quote', [
                    'card_id' => $request->card_id,
                    'amount' => $request->amount,
                ]);


                if ($quoteResponse->status() == 200) {
                    $quoteData = $quoteResponse->json()['data'];
                    //Calculate our charge
                    $flat = $this->client->issuing_fc + collect(json_decode($this->client->issuing_agents, true) ?? [])->sum('rev_fc');
                    $percent = $this->client->issuing_pc + collect(json_decode($this->client->issuing_agents, true) ?? [])->sum('rev_pc');
                    $agentflat = collect(json_decode($this->client->issuing_agents, true) ?? [])->sum('rev_fc');
                    $agentpercent = collect(json_decode($this->client->issuing_agents, true) ?? [])->sum('rev_pc');

                    $our_charge = (($quoteData['converted_to_usd'] * $percent / 100) + $flat)  + $quoteData['charge'];
                    $agent_charge = (($quoteData['converted_to_usd'] * $agentpercent / 100) + $agentflat);
                    $total = ($quoteData['converted_to_usd'] + $our_charge) * $request->quantity;
                } else {
                    $this->logError($quoteResponse->status(), $quoteResponse->json()['message'] ?? __('Error calculating quote'));
                    return response()->json(['message' => $quoteResponse->json()['message'] ?? __('Error calculating quote'), 'status' => 'failed', 'data' => null], $quoteResponse->status());
                }

                // return response()->json(['message' => [
                //     'total' => $total,
                //     'total_charge' => $total_charge,
                //     'our_charge' => $our_charge,
                //     'agent_charge' => $agent_charge,
                //     'usd' => $quoteData['converted_to_usd'],
                //     'dd' => $quoteData['total'],
                //     'redboxx_charge' => $quoteData
                // ], 'status' => 'failed', 'data' => null], 402);

                if ($balance->amount < $total && $this->mode == 'live') {
                    $this->logError(402, __('Insufficient Balance'));
                    return response()->json(['message' => __('Insufficient Balance'), 'status' => 'failed', 'data' => null], 402);
                }

                $orderResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . ($this->mode == 'live' ? config('settings.redboxx_api_key') : config('settings.redboxx_test_api_key')),
                ])->post(config('settings.redboxx_url') . '/v1/order', [
                    'card_id' => $request->card_id,
                    'name' => $request->name,
                    'quantity' => $request->quantity,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'phone_code' => $request->phone_code,
                    'amount' => $request->amount,
                ]);

                if (!in_array($orderResponse->status(), [200, 402])) {
                    $this->logError($orderResponse->status(), $orderResponse->json()['message'] ?? __('An error occurred'));
                    return response()->json(['message' => $orderResponse->json()['message'] ?? __('An error occurred'), 'status' => 'failed', 'data' => null], $orderResponse->status());
                } else {

                    $data = $orderResponse->json()['data'];

                    if ($this->mode == 'live') {
                        $balance->update(['amount' => $balance->amount - $total]);
                    }

                    $trx = Transactions::create([
                        'user_id' => $this->client->user_id,
                        'business_id' => $this->client->reference,
                        'amount' => $total - ($our_charge * $request->quantity),
                        'charge' => $our_charge * $request->quantity,
                        'ref_id' => Str::uuid(),
                        'trx_type' => 'debit',
                        'type' => 'giftcard_purchase',
                        'status' => 'success',
                        'mode' => $this->mode,
                        'card_id' => $card['id'],
                        'card_name' => $card['name'],
                        'card_currency' => $card['currency'],
                        'card_country' => $card['country'],
                        'card_amount' => $request->amount,
                        'quantity' => $request->quantity,
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'phone_code' => $request->phone_code,
                        'currency' => $this->settings->real->currency,
                        'rate' => $quoteData['exchange_rate']
                    ]);

                    if ($orderResponse->status() == 200) {
                        $this->settings->update([
                            'redboxx_low_notify' => 0
                        ]);
                        foreach ($data['order'] as $order) {
                            $issue = \App\Models\CardIssued::create([
                                'user_id' => $this->client->user_id,
                                'business_id' => $this->client->reference,
                                'amount' => $request->amount,
                                'rev_share' => $agent_charge,
                                'redboxx_share' => $our_charge - $agent_charge,
                                'status' => 'pending',
                                'order_id' => $order['id'],
                                'trx_id' => $trx->id,
                                'data' => json_encode($order),
                                'card_id' => $card['id'],
                                'currency' => $card['currency'],
                                'rate' => $quoteData['exchange_rate'],
                                'mode' => $this->mode,
                                'agents' => $this->client->issuing_agents,
                                'expires' => \Carbon\Carbon::create($order['expires']),
                                'card_id' => $card['id'],
                                'card_name' => $card['name'],
                                'card_currency' => $card['currency'],
                                'card_country' => $card['country'],
                                'name' => $request->name,
                                'email' => $request->email,
                                'phone' => $request->phone,
                            ]);
                        }
                    } else {
                        for ($i = 1; $i <= $request->quantity; $i++) {
                            $issue = \App\Models\CardIssued::create([
                                'user_id' => $this->client->user_id,
                                'business_id' => $this->client->reference,
                                'amount' => $request->amount,
                                'rev_share' => $agent_charge,
                                'redboxx_share' => ($our_charge / $request->quantity) - $agent_charge,
                                'status' => 'pending',
                                'trx_id' => $trx->id,
                                'card_id' => $card['id'],
                                'currency' => $card['currency'],
                                'rate' => $quoteData['exchange_rate'],
                                'mode' => $this->mode,
                                'agents' => $this->client->issuing_agents,
                                'card_name' => $card['name'],
                                'card_currency' => $card['currency'],
                                'card_country' => $card['country'],
                                'name' => $request->name,
                                'email' => $request->email,
                                'phone' => $request->phone,
                            ]);
                        }
                        if ($this->settings->redboxx_low_notify == 0) {
                            $this->settings->update([
                                'redboxx_low_notify' => 1
                            ]);
                            //dispatch(new SendEmail($this->settings->email, $this->settings->site_name, __('New giftcard order'), __('Hello admin, you have a giftcard purchase request for') . ' ' . $this->client->name, null, null, 0));
                        }
                    }

                    dispatch(new SendEmail($this->settings->email, $this->settings->site_name, __('New giftcard order'), __('Hello admin, you have a giftcard purchase request for') . ' ' . $this->client->name, null, null, 0));
                }
                $this->logError(200);
                return response()->json(['message' => __('Payment successful'), 'status' => 'success', 'data' => new TransactionResource($trx)], 200);
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' =>  __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function transactions(Request $request, $reference = null)
    {
        $limit = $request->limit;
        $this->verifyToken($request);
        if ($this->access == true) {
            try {
                $this->ipCheck();
                if ($reference != null) {
                    if (Transactions::whereMode($this->mode)->whereRefId($reference)->whereType('giftcard_purchase')->exists()) {
                        $this->logError(200);
                        return response()->json(['message' => __('Transaction details'), 'status' => 'success', 'data' => new TransactionResource(Transactions::whereMode($this->mode)->whereRefId($reference)->whereType('giftcard_purchase')->first())], 200);
                    } else {
                        $this->logError(404);
                        return response()->json(['message' => __('Transaction not found'), 'status' => 'failed', 'data' => null], 404);
                    }
                } else {
                    $this->logError(200);
                    return TransactionResource::collection(Transactions::whereMode($this->mode)->whereType('giftcard_purchase')->latest()
                        ->when($request->page == 'all', fn($query) => $query->get(), fn($query) => $query->paginate($limit ?? 20)));
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
