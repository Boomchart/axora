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
                $apiresponse = [
                    'message' => __('Countries'),
                    'status' => 'success',
                    'data' => CountryResource::collection(CountryReg::whereStatus(1)->withCount(['giftcards', 'airtimeProviders'])->orderBy('name', 'asc')
                        ->when($request->page == 'all', function ($query) {
                            return $query->get();
                        }, function ($query) use ($limit) {
                            return $query->when($limit !== null && is_int((int) $limit), function ($query) use ($limit) {
                                return $query->paginate($limit);
                            }, function ($query) {
                                return $query->paginate(20);
                            });
                        }))
                ];
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
}
