<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use App\Models\Settings;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            $this->renderable(function (\Exception $e, $request) {
                if ($e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException) {
                    return redirect(url()->previous())->with('alert', __('An error occurred, Try again'));
                }
                if ($request->is('api/*')) {
                    $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode()  : 500;
                    return response()->json([
                        'success' => false,
                        'message' => ($status != 500) ?: 'Server Error',
                        'statusCode' => $status,
                    ], $status);
                }
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
                    return back()->with('alert', __('Method not allowed'));
                }
            });
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if ($request->is(Settings::find(1)->admin_url) || $request->is(Settings::find(1)->admin_url . '/*')) {
            return redirect()->guest('/' . Settings::find(1)->admin_url);
        }
        if ($request->is('user') || $request->is('user/*')) {
            return redirect()->guest('/login');
        }
        return redirect()->guest(route('login'));
    }
}
