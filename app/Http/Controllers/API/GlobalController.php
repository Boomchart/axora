<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;
use App\Models\{Settings, CountryReg};
use App\Traits\ClientAuthenticate;

class GlobalController extends Controller
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
                if ($this->security_check) {
                    return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
                }
                $apiresponse = [
                    'message' => __('Account Balance'),
                    'status' => 'success',
                    'data' => [
                        'amount' => number_format($this->client->user->getBalance($this->settings->currency)->amount, 2, '.', ''),
                        'currency' => $this->settings->real->currency
                    ]
                ];
                $this->logError(200, $apiresponse);
                return response()->json($apiresponse, 200);
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' => __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            }
        } else {
            return response()->json(['message' => __('Invalid API Key'), 'status' => 'failed', 'data' => null], 401);
        }
    }

    public function countries(Request $request)
    {
        $limit = $request->limit;
        $this->verifyToken($request);
        if ($this->access == true) {
            try {
                $this->ipCheck();
                if ($this->security_check) {
                    return response()->json(['message' => $this->security_check, 'status' => 'failed', 'data' => null], 403);
                }
                $apiresponse = CountryResource::collection(CountryReg::whereStatus(1)->withCount(['giftcards', 'airtimeProviders'])->orderBy('name', 'asc')
                    ->when($request->page == 'all', function ($query) {
                        return $query->get();
                    }, function ($query) use ($limit) {
                        return $query->when($limit !== null && is_int((int) $limit), function ($query) use ($limit) {
                            return $query->paginate($limit);
                        }, function ($query) {
                            return $query->paginate(20);
                        });
                    }));
                $this->logError(200, (array)$apiresponse);
                return $apiresponse;
            } catch (\Exception $e) {
                $this->logError(500, $e->getMessage());
                return response()->json(['message' => __('Internal Server Error'), 'status' => 'failed', 'data' => null], 500);
            }
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
                    $airtime = AirtimeProvider::whereStatus(1)->whereId($request->operator_id)->first();
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
                            $apiresponse = ['message' => __('Network Operator details'), 'status' => 'success', 'data' => new AirtimeResource($airtime, $this->client)];
                            $this->logError(200, $apiresponse);
                            return response()->json($apiresponse, 200);
                        }
                    } else {
                        $apiresponse = ['message' => __('Airtime Operator not found'), 'status' => 'failed', 'data' => null];
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
}
