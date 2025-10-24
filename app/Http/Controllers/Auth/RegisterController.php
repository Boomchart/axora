<?php

namespace App\Http\Controllers\Auth;

use App\Models\Settings;
use App\Models\TeamInvites;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $settings;
    public function __construct()
    {
        $this->settings = Settings::find(1);
    }

    public function index()
    {
        if (auth()->guard('user')->check()) {
            $user = auth()->guard('user')->user();
            if ($user->email_verify && $user->business->fa_status) {
                return redirect()->route('user.dashboard');
            }
        }
        return view('onboarding.index', ['title' => 'Register']);
    }
}
