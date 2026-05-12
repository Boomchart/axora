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


Route::get('hasa-hmac', function () {
    /* HMAC TESTING */
    $body = [
        'chain' => 'ethereum',
        'network' => 'sepolia',
        'label' => 'SepWal'
    ];

    $apiKey = 'zOTOAI2C90QeNkzGD68oahBsg2Smu1reVRUd2Dc1ymo=';
    $secretKey = 'mRDhw_KujIw9e-R2uay3_sUD080vBNcEi6-yluvNIik=';

    $result = generateHasaHMACAuth($body,$apiKey,$secretKey);
    dd($result);
});

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
    Route::view('api-keys', 'developer.api-keys', ['title' => __('Get API Keys')])->name('developer.api-keys');
});

Route::prefix('api-reference')->group(function () {
    Route::prefix('gift-cards')->group(function () {
        Route::view('single', 'developer.reference.card.single', ['title' => __('Single Card')])->name('developer.card.single');
        Route::view('all', 'developer.reference.card.all', ['title' => __('All Card')])->name('developer.card.all');
        Route::view('order', 'developer.reference.card.order', ['title' => __('Order Gift Card')])->name('developer.card.order');
        Route::view('quote', 'developer.reference.card.quote', ['title' => __('Gift Card Quote')])->name('developer.card.quote');
        Route::view('transactions', 'developer.reference.card.transactions', ['title' => __('Gift Card Transactions')])->name('developer.card.transactions');
        Route::view('transaction', 'developer.reference.card.transaction', ['title' => __('Gift Card Transaction')])->name('developer.card.transaction');
    });

    Route::prefix('airtime')->group(function () {
        Route::view('lookup', 'developer.reference.airtime.airtime-lookup', ['title' => __('Airtime Lookup')])->name('developer.airtime.lookup');
        Route::view('operators', 'developer.reference.airtime.operators', ['title' => __('List Airtime Operators')])->name('developer.airtime.operators');
        Route::view('operator', 'developer.reference.airtime.operator', ['title' => __('Get Airtime Operator')])->name('developer.airtime.operator');
        Route::view('quote', 'developer.reference.airtime.quote', ['title' => __('Airtime Quote')])->name('developer.airtime.quote');
        Route::view('order', 'developer.reference.airtime.order', ['title' => __('Airtime Order')])->name('developer.airtime.order');
        Route::view('transactions', 'developer.reference.airtime.transactions', ['title' => __('List Airtime Transactions')])->name('developer.airtime.transactions');
        Route::view('transaction', 'developer.reference.airtime.transaction', ['title' => __('Get Airtime Transaction')])->name('developer.airtime.transaction');
    });

    Route::prefix('data')->group(function () {
        Route::view('lookup', 'developer.reference.data.data-lookup', ['title' => __('Data Lookup')])->name('developer.data.lookup');
        Route::view('operators', 'developer.reference.data.operators', ['title' => __('List Data Operators')])->name('developer.data.operators');
        Route::view('operator', 'developer.reference.data.operator', ['title' => __('Get Data Operator')])->name('developer.data.operator');
        Route::view('quote', 'developer.reference.data.quote', ['title' => __('Data Quote')])->name('developer.data.quote');
        Route::view('order', 'developer.reference.data.order', ['title' => __('Data Order')])->name('developer.data.order');
        Route::view('transactions', 'developer.reference.data.transactions', ['title' => __('List Data Transactions')])->name('developer.data.transactions');
        Route::view('transaction', 'developer.reference.data.transaction', ['title' => __('Get Data Transaction')])->name('developer.data.transaction');
    });

    Route::view('countries', 'developer.reference.countries', ['title' => __('Countries')])->name('developer.countries');

    Route::view('balance', 'developer.reference.balance', ['title' => __('Account Balance')])->name('developer.balance');

});

Route::group(['middleware' => 'DefaultHeader:denyIframe'], function () {
    // Frontend routes
    Route::view('/', 'front.pages.index')->name('home');
    Route::get('unsubscribe/{contact}', [FrontendController::class, 'unsubscribe'])->name('unsubscribe');
    Route::view('terms', 'front.pages.terms', ['title' => __('Terms & conditions')])->name('terms');
    Route::view('privacy', 'front.pages.privacy', ['title' => __('Privacy Policy')])->name('privacy');
    Route::view('security', 'front.pages.security', ['title' => __('Security')])->name('security');
    Route::view('solutions', 'front.pages.solutions', ['title' => __('Solutions')])->name('solutions');
    Route::view('contact', 'front.pages.contact', ['title' => __('Contact Us')])->name('contact');
    Route::view('about-us', 'front.pages.about', ['title' => __('About Us')])->name('about');
    Route::get('card/{slug}', [FrontendController::class, 'card'])->name('card.category');
    Route::post('contact', [FrontendController::class, 'contactSubmit'])->name('contact-submit');
    Route::prefix('help-center')->group(function () {
        Route::view('index', 'front.helpcenter.index', ['title' => __('Help Center')])->name('help.center');
        Route::get('articles/{article:slug}', [FrontEndController::class, 'helpCenterArticle'])->name('help.article');
        Route::get('topic/{topic}', [FrontEndController::class, 'helpCenterTopic'])->name('help.topic');
        Route::get('search-results', [FrontEndController::class, 'searchHelpCenter'])->name('help.search-results');
    });
    Route::name('blog.')->group(function () {
        Route::get('blog', [FrontendController::class, 'blog'])->name('index');
        Route::get('posts/{blog:slug}', [FrontEndController::class, 'blogArticle'])->name('article');
        Route::get('categories/{category}/{slug}', [FrontEndController::class, 'blogCategory'])->name('category');
        Route::get('blog/results', [FrontEndController::class, 'searchBlog'])->name('search');
    });
    Route::view('pricing', 'front.pages.pricing', ['title' => __('Pricing')])->name('pricing');

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
                    Route::view('all', 'user.orders.index', ['title' => __('Gift Card Orders')])->name('user.orders');
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
                Route::view('all', 'admin.orders.index', ['title' => __('Gift Card Orders')])->name('admin.orders');
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

            Route::group(['prefix' => 'airtime'], function () {
                Route::get('providers/{country}', [SettingController::class, 'countryAirtimeProviders'])->name('admin.airtime.providers');
            });

            Route::group(['prefix' => 'data'], function () {
                Route::get('providers/{country}', [SettingController::class, 'countryDataProviders'])->name('admin.data.providers');
            });

            Route::group(['prefix' => 'giftcard'], function () {
                Route::view('countries', 'admin.giftcard.country', ['title' => __('Countries')])->name('admin.giftcard.country');
                Route::get('cards/{country}', [SettingController::class, 'countryCards'])->name('admin.giftcard.cards');
                Route::get('orders-filter/{card}', [SettingController::class, 'orderTrxFilter'])->name('admin.giftcard.orders.filter');
                Route::view('category', 'admin.giftcard.category', ['title' => __('Giftcard Category')])->name('admin.giftcard.category');
            });
        });
    });
});
