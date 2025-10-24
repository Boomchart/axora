<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Models\Settings;
use App\Models\User;
use App\Models\Language;


Route::get('change-lang/{locale}', [SettingController::class, 'locale'])->name('lang');

Route::controller(SettingController::class)->group(function () {
    Route::get('optimize', 'optimize')->name('optimize.system');
    Route::get('migrate', 'migrate')->name('run.migration');
});

Route::post('redboxx_webhook', [UserController::class, 'redboxx'])->name('redboxx.webhook');

Route::prefix('docs')->group(function () {
    Route::view('introduction', 'developer.index', ['title' => 'Introduction'])->name('developer.index');
    Route::view('errors', 'developer.errors', ['title' => 'Errors'])->name('developer.errors');
    Route::view('webhook', 'developer.webhook', ['title' => 'Webhooks'])->name('developer.webhook');
    Route::view('authentication', 'developer.authentication', ['title' => __('Authentication')])->name('developer.authentication');
    Route::view('environments', 'developer.environments', ['title' => __('Environments')])->name('developer.environments');
    Route::prefix('transaction')->group(function () {
        Route::view('transaction', 'developer.transaction.single', ['title' => __('Single Transaction')])->name('developer.transaction.single');
        Route::view('transactions', 'developer.transaction.all', ['title' => __('All Transaction')])->name('developer.transaction.all');
    });

    Route::prefix('card')->group(function () {
        Route::view('card', 'developer.card.single', ['title' => __('Single Card')])->name('developer.card.single');
        Route::view('cards', 'developer.card.all', ['title' => __('All Card')])->name('developer.card.all');
    });

    Route::view('countries', 'developer.countries', ['title' => __('Countries')])->name('developer.countries');
    Route::view('order', 'developer.order', ['title' => __('Order Card')])->name('developer.order');
    Route::view('balance', 'developer.balance', ['title' => __('Account Balance')])->name('developer.balance');
    Route::view('quote', 'developer.quote', ['title' => __('Get a Quote')])->name('developer.quote');
});

Route::group(['middleware' => 'DefaultHeader:denyIframe'], function () {
    // Frontend routes
    Route::view('/', 'front.index')->name('home');

    Route::get('unsubscribe/{contact}', [FrontendController::class, 'unsubscribe'])->name('unsubscribe');
    Route::view('terms', 'front.terms', ['title' => __('Terms & conditions')])->name('terms');
    Route::view('privacy', 'front.privacy', ['title' => __('Privacy Policy')])->name('privacy');
    Route::view('contact', 'front.contact', ['title' => __('Contact Us')])->name('contact');
    Route::get('page/{page:slug}', [FrontendController::class, 'page'])->name('page');
    Route::get('card/{slug}', [FrontendController::class, 'card'])->name('card.category');
    Route::post('contact', [FrontendController::class, 'contactSubmit'])->name('contact-submit');

    // User routes
    Route::get('login', [LoginController::class, 'showLoginform'])->name('login');

    Route::get('reactivate/{user}', [UserController::class, 'reactivate'])->name('reactivate');

    Route::get('create_account', [RegisterController::class, 'index'])->name('register');

    Route::group(['prefix' => 'user', 'middleware' => 'web'], function () {
        Route::group(['middleware' => 'auth:user'], function () {
            Route::group(['prefix' => 'multi-factor'], function () {
                Route::view('user', 'auth.multi-factor.user', ['title' => __('Unlock')])->name('2fa');
                Route::view('admin', 'auth.multi-factor.admin', ['title' => __('Unlock')])->name('admin.2fa');
            });

            Route::middleware(['Maintenance', 'Blocked', 'Email', 'Tfa', 'Localization'])->group(function () {
                Route::group(['prefix' => 'compliance'], function () {
                    Route::get('index', [UserController::class, 'compliance'])->name('user.compliance');
                    Route::post('upload/{cloud?}', [UserController::class, 'kycImageUpload'])->name('kyc.image.upload');
                });

                Route::group(['prefix' => 'profile'], function () {
                    Route::get('index/{type}', [UserController::class, 'profile'])->name('user.profile');
                });

                Route::group(['prefix' => 'ticket'], function () {
                    Route::view('all', 'user.support.index', ['title' => __('Support')])->name('user.ticket');
                });

                Route::group(['prefix' => 'transactions'], function () {
                    Route::view('all', 'user.transactions.index', ['title' => __('Transactions')])->name('user.transactions');
                    Route::get('details/{transaction:ref_id}', [UserController::class, 'detailsTransaction'])->name('view.transactions');
                });

                Route::group(['prefix' => 'orders'], function () {
                    Route::view('all', 'user.orders.index', ['title' => __('Orders')])->name('user.orders');
                    Route::get('details/{order}', [UserController::class, 'detailsOrder'])->name('view.orders');
                });

                Route::view('webhook-log', 'user.webhook', ['title' => __('Webhook Logs')])->name('webhook.logs');
                Route::view('api-log', 'user.api-log', ['title' => __('API Logs')])->name('api.logs');
                Route::view('dashboard', 'user.dashboard.index', ['title' => __('Dashboard')])->name('user.dashboard');
            });
        });
        Route::get('logout', [UserController::class, 'logout'])->name('user.logout');
    });

    Route::group(['prefix' => 'password'], function () {
        Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('user.password.request');
        Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('user.password.email');
        Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('user.password.reset');
        Route::post('reset', [ResetPasswordController::class, 'reset']);
    });

    Route::controller(AdminController::class)->group(function () {
        Route::get(Settings::find(1)->admin_url, 'adminlogin')->name('admin.loginForm');
        Route::post(Settings::find(1)->admin_url, 'submitadminlogin')->name('admin.login');
        Route::post('admin-check', 'submitAdminCheck')->name('admin.check');
        Route::get('admin-reset', 'reset')->name('admin.reset');
        Route::get('admin-resetlink/{id}', 'resetLink')->name('admin.reset.link');
    });

    Route::group(['prefix' => Settings::find(1)->admin_url, 'middleware' => 'auth:admin'], function () {
        Route::view('api-log', 'admin.dashboard.api-log', ['title' => __('API Logs')])->name('admin.api.logs');
        Route::get('logout', [SettingController::class, 'logout'])->name('admin.logout');
        Route::middleware(['AdminTfa'])->group(function () {
            Route::view('dashboard', 'admin.dashboard.index', ['title' => __('Dashboard')])->name('admin.dashboard');

            Route::controller(SettingController::class)->group(function () {
                Route::group(['middleware' => 'Admin:general_settings'], function () {
                    Route::post('home-page', 'updateHome')->name('homepage.update');
                    Route::post('section-image/{section}', 'sectionImage')->name('section.image');
                    Route::get('settings/{type}/{country?}', 'settings')->name('admin.settings');
                    Route::post('settings/{type}', 'update')->name('admin.settings.update');
                    Route::post('currency/{currency}', 'updateCurrency')->name('update.currency');
                    Route::post('logo/{type}', 'logoUpload')->name('logo.upload');
                    Route::get('kyc/{reg}', function ($reg = null) {
                        return view('admin.reg.kyc', ['title' => __('KYC documents'), 'reg' => \App\Models\Category::find($reg)]);
                        abort(403);
                    })->name('admin.reg.kyc');
                });
                Route::group(['middleware' => 'Admin:email_configuration'], function () {
                    Route::get('template/{type}', 'email')->name('template.settings');
                });
            });

            Route::group(['middleware' => 'Admin:profile'], function () {
                Route::get('users/{type}', [SettingController::class, 'users'])->name('admin.users');
                Route::view('kyc', 'admin.user.index', ['title' => __('Pending KYC'), 'type' => 'kyc'])->name('admin.kyc');
                Route::view('watchlist', 'admin.user.index', ['title' => __('Watch List'), 'type' => 'watchlist'])->name('admin.watchlist');
                Route::get('manage-user/{client}/{type}', function (User $client, $type) {
                    if (in_array($type, ['details', 'devices', 'bank', 'beneficiaries', 'compliance', 'audit', 'beneficiary', 'ticket', 'sent-emails', 'transactions', 'orders', 'api-log', 'webhook'])) {
                        return view('admin.user.manage', ['title' => __('Manage User'), 'client' => $client, 'type' => $type]);
                    }
                    abort(403);
                })->name('user.manage')->withTrashed();
            });

            Route::group(['middleware' => 'Admin:support'], function () {
                Route::get('ticket/{type}', function ($type) {
                    if (in_array($type, ['open', 'closed'])) {
                        return view('admin.support.index', ['title' => __('Ticket'), 'type' => $type]);
                    }
                    abort(403);
                })->name('admin.ticket');
            });

            Route::group(['middleware' => 'Admin:news'], function () {
                Route::get('blog/{type}', function ($type) {
                    if (in_array($type, ['articles', 'category', 'draft', 'deleted'])) {
                        return view('admin.blog.index', ['title' => __('Articles'), 'type' => $type]);
                    }
                    abort(403);
                })->name('admin.blog');
            });

            Route::group(['prefix' => 'transactions'], function () {
                Route::view('all', 'admin.transactions.index', ['title' => __('Transactions')])->name('admin.transactions');
                Route::get('details/{transaction:ref_id}', [SettingController::class, 'detailsTransaction'])->name('admin.view.transactions');
            });

            Route::group(['prefix' => 'orders'], function () {
                Route::view('all', 'admin.orders.index', ['title' => __('Orders')])->name('admin.orders');
                Route::get('details/{order}', [SettingController::class, 'detailsOrder'])->name('admin.view.orders');
            });

            Route::group(['middleware' => 'Admin:message'], function () {
                Route::get('messages/{type}', function ($type) {
                    if (in_array($type, ['inbox', 'sent', 'contacts', 'deleted'])) {
                        return view('admin.message.index', ['title' => __('Messages'), 'type' => $type]);
                    }
                    abort(403);
                })->name('admin.message');
            });

            Route::group(['middleware' => 'Admin:language'], function () {
                Route::group(['prefix' => 'language'], function () {
                    Route::view('index', 'admin.language.index', ['title' => __('Language')])->name('admin.language');
                    Route::get('edit/{lang}', function (Language $lang) {
                        return view('admin.language.edit', ['title' => __('Languages'), 'lang' => $lang]);
                    })->name('admin.edit.language');
                });
            });

            Route::group(['middleware' => 'Admin:deposit'], function () {
                Route::get('deposit/{type}', function ($type) {
                    if (in_array($type, ['pending', 'declined', 'success'])) {
                        return view('admin.deposit.index', ['title' => __('Deposits'), 'type' => $type]);
                    }
                    abort(403);
                })->name('admin.deposit');
            });

            Route::group(['middleware' => 'Admin:payout'], function () {
                Route::get('payout/{type}', function ($type) {
                    if (in_array($type, ['pending', 'declined', 'success'])) {
                        return view('admin.payout.index', ['title' => __('Payouts'), 'type' => $type]);
                    }
                    abort(403);
                })->name('admin.payout');
            });

            Route::group(['prefix' => 'staff', 'middleware' => 'Admin'], function () {
                Route::view('staff', 'admin.staff.index', ['title' => __('Staffs')])->name('admin.staffs');
            });

            Route::group(['middleware' => 'Admin:firewall'], function () {
                Route::group(['prefix' => 'firewall', 'middleware' => 'Admin'], function () {
                    Route::view('staff', 'admin.firewall.index', ['title' => __('Firewall')])->name('admin.firewall');
                });
            });
        });
    });
});
