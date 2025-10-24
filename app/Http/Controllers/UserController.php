<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\UserKyc;
use App\Models\CardIssued;
use App\Models\Transactions;
use Carbon\Carbon;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    protected $user;
    protected $settings;

    public function __construct()
    {
        $this->settings = Settings::find(1);
        $self = $this;
        $this->middleware(function (Request $request, $next) use ($self) {
            $self->user = auth()->guard('user')->user();
            return $next($request);
        });
    }

    public function redboxx(Request $request)
    {
        $secret = config('settings.redboxx_webhook_hash');
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
            $issue = \App\Models\CardIssued::whereOrderId($payload['data']['id'])->first();
            if ($issue) {
                if ($issue->status == 'pending') {
                    $issue->update([
                        'status' => $payload['data']['status'],
                        'card_code' => $payload['data']['card_code'],
                        'card_url' => $payload['data']['card_url'],
                        'data' => json_encode($payload['data']),
                    ]);

                    if ($payload['data']['status'] == 'success') {
                        if ($issue->business_id) {
                            if ($issue->business->webhook_url) {
                                dispatch(new \App\Jobs\Webhook\Issue($issue));
                            }
                        }
                    }
                }
            }
        } elseif ($payload['event'] == 'redemption') {
            $issue = \App\Models\CardIssued::whereOrderId($payload['data']['id'])->first();
            if ($issue) {
                if ($issue->business_id) {
                    if ($issue->business->webhook_url) {
                        dispatch(new \App\Jobs\Webhook\Redemption($payload['data'], $issue));
                    }
                }
            }
        }
    }

    public function detailsTransaction(Transactions $transaction)
    {
        if ($transaction->business_id == $this->user->business_id) {
            return view('user.transactions.details', ['title' => __('Transaction Details'), 'val' => $transaction]);
        } else {
            abort(403);
        }
    }

    public function detailsOrder(CardIssued $order)
    {
        if ($order->business_id == $this->user->business_id) {
            return view('user.orders.details', ['title' => __('Order Details'), 'val' => $order]);
        } else {
            abort(403);
        }
    }

    public function compliance()
    {
        if ($this->user->business->kyc_status == null || $this->user->business->kyc_status == "DECLINED" || $this->user->business->kyc_status == "PENDING" || $this->user->business->kyc_status == "RESUBMIT") {
            return view('user.compliance.index');
        } elseif ($this->user->business->kyc_status == "PROCESSING") {
            return redirect()->route('user.dashboard')->with('alert', __('We are reviewing your compliance'));
        } elseif ($this->user->business->kyc_status == "DECLINED") {
            return redirect()->route('user.dashboard')->with('alert', __('Compliance has been rejected'));
        } else {
            return redirect()->route('user.dashboard')->with('alert', __('Compliance is already approved'));
        }
    }

    public function kycImageUpload(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300);
        $type = $request->type;
        try {
            if (in_array($request->file($type)->getMimeType(), allowedFileTypesArray())) {
                $file = $request->file($type);
                $mimeType = $file->getMimeType();

                // Different upload settings for PDFs
                if ($mimeType === 'application/pdf') {
                    $upload = $file->store('kyc', 'public');
                    $path = asset('storage/' . $upload);
                } else {
                    // Regular upload for images/other files
                    $path = Cloudinary::upload($file->getRealPath())->getSecurePath();
                }

                $folder = uniqid() . '-' . now()->timestamp;

                if (UserKyc::whereUserId($this->user->id)->whereDocId($type)->exists()) {
                    UserKyc::whereUserId($this->user->id)->whereDocId($type)->first()->update([
                        'value' => $path,
                    ]);
                } else {
                    UserKyc::create([
                        'user_id' => $this->user->id,
                        'doc_id' => $type,
                        'value' => $path,
                    ]);
                }
                return $folder;
            } else {
                return response()->json(['error' => __('Invalid file type')], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function profile($type)
    {
        if (!in_array($type, ['profile', 'bank', 'security', 'notifications', 'beneficiary', 'api'])) {
            abort(403);
        }
        $g = new GoogleAuthenticator();
        $secret = $g->generateSecret();
        $image = GoogleQrUrl::generate($this->user->email, $secret, $this->settings->site_name);
        return view('user.profile.index', ['title' => __('Settings'), 'type' => $type, 'secret' => $secret, 'image' => $image]);
    }

    public function logout()
    {
        createAudit('Logged Out');
        if (Auth::guard('user')->check()) {
            $this->user->update(['fa_expiring' => Carbon::now()->subMinutes(30)]);
            Auth::guard('user')->logout();
            session()->flash('message', __('Just Logged Out!'));
            return redirect()->route('login');
        } else {
            return redirect()->route('login');
        }
    }
}
