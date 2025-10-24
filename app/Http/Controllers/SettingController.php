<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;
use App\Models\CountryReg;
use App\Models\Settings;
use App\Models\CardIssued;
use App\Models\Design;
use App\Models\Transactions;
use App\Models\Admin;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;
use Carbon\Carbon;

class SettingController extends Controller
{
    protected $admin;
    protected $settings;

    public function __construct()
    {
        $this->settings = Settings::find(1);
        $self = $this;
        $this->middleware(function (Request $request, $next) use ($self) {
            $self->admin = auth()->guard('admin')->user();
            return $next($request);
        });
    }

    public function users($type)
    {
        return view('admin.user.index', ['title' => __('Users'), 'type' => $type]);
    }

    public function detailsTransaction(Transactions $transaction)
    {
        return view('admin.transactions.details', ['title' => __('Transaction Details'), 'val' => $transaction]);
    }

    public function detailsOrder(CardIssued $order)
    {
        return view('admin.orders.details', ['title' => __('Order Details'), 'val' => $order]);
    }

    public function locale($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

    public function settings($type, $country = null)
    {
        if (!in_array($type, ['system', 'security', 'policies', 'logo', 'country', 'regtype', 'mcc', 'file_types', 'deposit', 'payout'])) {
            abort(403);
        }
        $g = new GoogleAuthenticator();
        $secret = $g->generateSecret();
        $image = GoogleQrUrl::generate($this->admin->username, $secret, $this->settings->site_name, 140);
        $ui = Design::findOrFail(1);
        return view('admin.settings.index', ['title' => __('General settings'), 'ui' => $ui, 'type' => $type, 'country' => CountryReg::find($country), 'secret' => $secret, 'image' => $image]);
    }

    public function logout()
    {
        $settings = Settings::find(1);
        auth()->guard('admin')->logout();
        return redirect('/' . $settings->admin_url)->with('success', __('Just Logged Out!'));
    }

    public function email($type)
    {
        if (!in_array($type, ['settings', 'email-template', 'sms-template', 'code'])) {
            abort(403);
        }
        return view('admin.settings.template', ['title' => __('Template settings')]);
    }

    public function updateHome(Request $request)
    {
        $data = Design::findOrFail(1);
        $data->fill($request->all())->save();
        return back()->with('success', __('Updated'));
    }

    public function sectionImage(Request $request, $section)
    {
        try {
            $data = Design::find(1);
            $upload = Image::make($request->file('image'))->save(public_path('asset/images/' . 'section_' . $section . '.' . $request->file('image')->extension()));
            if ($section == 1) {
                File::delete(public_path('asset/image/' . $data->image1));
                $data->image1 = $upload->basename;
            } elseif ($section == 2) {
                File::delete(public_path('asset/image/' . $data->image2));
                $data->image2 = $upload->basename;
            } elseif ($section == 3) {
                File::delete(public_path('asset/image/' . $data->image3));
                $data->image3 = $upload->basename;
            } elseif ($section == 4) {
                File::delete(public_path('asset/image/' . $data->image4));
                $data->image4 = $upload->basename;
            } elseif ($section == 5) {
                File::delete(public_path('asset/image/' . $data->image5));
                $data->image5 = $upload->basename;
            } elseif ($section == 6) {
                File::delete(public_path('asset/image/' . $data->image6));
                $data->image6 = $upload->basename;
            } elseif ($section == 7) {
                File::delete(public_path('asset/image/' . $data->image7));
                $data->image7 = $upload->basename;
            } elseif ($section == 8) {
                File::delete(public_path('asset/image/' . $data->image8));
                $data->image8 = $upload->basename;
            } elseif ($section == 9) {
                File::delete(public_path('asset/image/' . $data->image9));
                $data->image9 = $upload->basename;
            } elseif ($section == 10) {
                File::delete(public_path('asset/image/' . $data->image10));
                $data->image10 = $upload->basename;
            } elseif ($section == 11) {
                File::delete(public_path('asset/image/' . $data->image11));
                $data->image11 = $upload->basename;
            }
            $data->save();
            return back()->with('success', __('Updated'));
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function logoUpload(Request $request, $type)
    {
        try {
            if ($request->hasFile('image')) {
                if ($type == "light") {
                    $location = public_path('asset/images/logo.png');
                    File::delete(public_path('asset/images/logo.png'));
                } else if ($type == "dark") {
                    $location = public_path('asset/images/dark_logo.png');
                    File::delete(public_path('asset/images/dark_logo.png'));
                } else if ($type == "favicon") {
                    $location = public_path('asset/images/favicon.png');
                    File::delete(public_path('asset/images/favicon.png'));
                }
                Image::make($request->file('image'))->save($location);
            }
            $data = Design::findOrFail(1);
            if ($type == "css") {
                $data->fill($request->except('image'))->save();
            }
            return back()->with('success', __('Updated'));
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function update(Request $request, $type)
    {
        $data = Settings::findOrFail(1);
        if ($type == "recaptcha") {
            $data->fill($request->all())->save();
            $data->recaptcha = (empty($request->recaptcha)) ? 0 : $request->recaptcha;
            $data->save();
        } else if ($type == "email_template") {
            if (strpos($request->email_template, "{{message}}") === false || strpos($request->email_template, "{{logo}}") === false) {
                return back()->with('alert', __('{{message}} tag & {{logo}} tag are required'));
            } else {
                $data->update(['email_template' => $request->email_template]);
            }
        } else if ($type == "2fa") {
            $validator = Validator::make(
                $request->all(),
                [
                    'fa_pin' => ['numeric', 'required', 'min_digits:6', 'max_digits:6', 'regex:/[0-9]+/'],
                    'secret' => ['required']
                ]
            );
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }
            $g = new GoogleAuthenticator();
            if ($this->admin->fa_status == 1) {
                if ($g->checkcode($this->admin->googlefa_secret, $request->fa_pin, 3)) {
                    $this->admin->update([
                        'fa_status' => 0,
                        'googlefa_secret' => null,
                    ]);
                    return back()->with('success', __('2fa disabled'));
                } else {
                    return back()->with('alert', __('Invalid code'))->withInput();
                }
            } else {
                if ($g->checkcode($request->secret, $request->fa_pin, 3)) {
                    $this->admin->update([
                        'fa_status' => 1,
                        'googlefa_secret' => $request->secret,
                        'fa_expiring' => Carbon::now()->addHours(2)
                    ]);
                    return back()->with('success', __('2fa enabled'));
                } else {
                    return back()->with('alert', __('Invalid code'))->withInput();
                }
            }
        } else if ($type == "system") {
            $data->fill($request->except(['admin_timezone']))->save();
            $this->admin->update(['timezone' => $request->admin_timezone]);
            App::setLocale($this->settings->admin_language);
        } else if ($type == "preloader") {
            $data->fill($request->all())->save();
            $data->preloader = (empty($request->preloader)) ? 0 : $request->preloader;
            $data->save();
        } else if ($type == "language") {
            $data->fill($request->all())->save();
            $data->language = (empty($request->language)) ? 0 : $request->language;
            $data->save();
        }  else if ($type == "bank_deposit") {
            $validate = Validator::make($request->all(), [
                'deposit_pct' => ['required'],
                'deposit_fiat_pc' => ['required', 'numeric'],
                'deposit_percent_pc' => ['required', 'numeric'],
            ]);
            if ($validate->fails()) {
                return back()->withErrors($validate->errors())->withInput();
            }
            $data->fill($request->all())->save();
            $data->bk_status = (empty($request->bk_status)) ? 0 : $request->bk_status;
            $data->save();
        }else if ($type == "security") {
            $admin = Admin::whereId(auth()->guard('admin')->user()->id)->first();
            $admin->update([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
            $data->update([
                'admin_url' => $request->admin_url
            ]);
        } else if ($type == "permissions") {
            $data->maintenance = (empty($request->maintenance)) ? 0 : $request->maintenance;
            $data->registration = (empty($request->registration)) ? 0 : $request->registration;
            $data->email_verify = (empty($request->email_verify)) ? 0 : $request->email_verify;
            $data->save();
        } else if ($type == "email_banned") {
            $data->update([
                'email_banned' => $request->email_banned
            ]);
        } else if ($type == "settings" || $type == "otp" || $type == "policies") {
            $data->fill($request->all())->save();
        }
        return back()->with('success', __('Updated'));
    }

    public function optimize()
    {
        Artisan::call('optimize:clear');
        return back()->with('success', __('Cache, Route, Config, View optimized'));
    }

    public function migrate()
    {
        Artisan::call('migrate', ['--path' => 'database/migrations', '--force' => true]);
        return back()->with('success', __('System has been updated'));
    }
}
