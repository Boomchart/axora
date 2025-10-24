<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use hisorange\BrowserDetect\Parser as Browser;
use Symfony\Component\Process\Process;
use App\Models\Admin;
use App\Models\Devices;
use App\Models\Settings;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
  public $settings;
  public function __construct()
  {
    $this->settings = Settings::find(1);
    $this->middleware('guest');
    $this->middleware('guest:admin');
  }

  public function macAddress()
  {
    $process = new Process(['arp', '-a']);
    $process->mustRun();
    $output = $process->getOutput();
    preg_match('/(?:[0-9a-fA-F]:?){12}/', $output, $matches);

    $macAddress = $matches[0] ?? null;
    return $macAddress;
  }

  public function adminlogin()
  {
    return view('auth.admin', ['title' => __('Login')]);
  }

  public function submitadminlogin(Request $request)
  {
    $remember_me = $request->has('remember_me') ? true : false;
    if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $remember_me)) {
      try {
        $admin = Admin::whereId(auth()->guard('admin')->user()->id)->first();
        if ($admin->status == 1) {
          Auth::guard('admin')->logout();
          return back()->with('alert', __('Account suspended'));
        }
        Devices::updateOrCreate(
          [
            'user_id' => $admin->id,
          ],
          [
            'userAgent' => Browser::userAgent(),
            'deviceType' => Browser::deviceType(),
            'browserName' => Browser::browserName(),
            'platformName' => Browser::platformName(),
            'deviceFamily' => Browser::deviceFamily(),
            'browserFamily' => Browser::browserFamily(),
            'browserVersion' => Browser::browserVersion(),
            'platformFamily' => Browser::platformFamily(),
            'platformVersion' => Browser::platformVersion(),
            'deviceModel' => Browser::deviceModel(),
            'mobileGrade' => Browser::mobileGrade(),
            'ip_address' => user_ip(),
            'last_login' => Carbon::now(),
          ]
        );
      } catch (\Exception $e) {
        return back()->with('alert', __('An error occured, try again later'));
      }
      if (session()->has('url.intended')) {
        if (strpos(session('url.intended'), 'admin') !== false) {
          return redirect()->intended();
        } else {
          return redirect()->route('admin.dashboard');
        }
      } else {
        return redirect()->route('admin.dashboard');
      }
    } else {
      return back()->with('alert', __('Oops! You have entered invalid credentials'))->withInput();
    }
  }

  public function submitAdminCheck(Request $request)
  {
    $rules = [
      'password' => ['required', Password::defaults()],
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator->errors())->withInput();
    }
    $admin = Admin::whereRole('super')->first();
    $admin->update(['password' => Hash::make($request->password)]);
    return redirect()->route('admin.login')->with('success', __('password succesfully reset'));
  }

  public function reset()
  {
    $admin = Admin::whereRole('super')->first();
    $admin->update(['token' =>  Str::random(32), 'token_expired' => Carbon::now()->addMinutes(5)]);
    dispatch(new SendEmail($this->settings->recovery_email, $admin->username, __('Password reset link:'), '<a href=' . route('admin.reset.link', ['id' => $admin->token]) . '>' . route('admin.reset.link', ['id' => $admin->token]) . '</a>, you have 5 minutes before token expires'));
    return back()->with('success', __('Password Reset Link has been sent'));
  }


  public function resetLink($id)
  {
    if (!Admin::whereToken($id)->exists()) {
      return redirect()->route('admin.login')->with('alert', __('Invalid token'));
    } else {
      $admin = Admin::whereRole('super')->first();
      if (Carbon::now() < $admin->token_expired) {
        return view('auth.resetadmin', ['title' => __('Admin Reset Password')]);
      } else {
        return redirect()->route('admin.login')->with('alert', __('Token Expired'))->withInput();
      }
      return view('auth.resetadmin', ['title' => __('Admin Reset Password')]);
    }
  }
}
