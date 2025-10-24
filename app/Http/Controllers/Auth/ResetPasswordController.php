<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Models\PasswordHistory;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function showResetForm(Request $request, $token)
    {
        if (!PasswordReset::whereToken(($token == null) ? $request->token : $token)->exists()) {
            return redirect()->route('user.password.request')->with('alert', __('Invalid Token!'));
        } else {
            $tk = PasswordReset::whereToken(($token == null) ? $request->token : $token)->first();
            return view('auth.passwords.reset', ['title' => __('Change Password'), 'token' => ($token == null) ? $request->token : $token, 'email' => $tk->email]);
        }
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'same:confirm-password', Password::defaults()],
            'confirm-password' => ['required']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $tk = PasswordReset::whereToken($request->token)->first();
        $user = User::whereEmail($tk->email)->first();
        if (!$user) {
            return back()->with('alert', __('Invalid Token!'));
        } else {
            foreach ($user->passwords as $check) {
                if ($check->password == hash('sha256', $request->password)) {
                    return back()->with('alert', __('You entered a previously used password, enter a new password'));
                }
            }

            PasswordHistory::create([
                'email' => $user->email,
                'password' => hash('sha256', $request->password)
            ]);
            $user->password = bcrypt($request->password);
            $user->save();
            createAudit('Reset password', $user);
            return redirect()->route('login')->with('success', __('Password successfully changed.'));
        }
    }
}
