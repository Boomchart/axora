<?php

use App\Models\Settings;
use App\Models\Design;
use App\Models\Services;
use App\Models\Brands;
use App\Models\Review;
use App\Models\Page;
use App\Models\Social;
use App\Models\Blog;
use App\Models\Audit;
use App\Models\LeaderShip;
use App\Models\Category;
use App\Models\Country;
use App\Models\Business;
use App\Models\Gateway;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\HelpCenter;
use App\Models\Language;
use App\Models\CountryReg;
use App\Models\OTP;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

function regCountries()
{
    return CountryReg::whereStatus(1)->with(['real'])->orderBy('name', 'asc')->get();
}

function mcc()
{
    return Category::whereType('mcc')->orderby('name', 'asc')->get();
}

function businessRegType()
{
    return Category::whereType('regtype')->orderby('name', 'asc')->get();
}

function allowedFileSize()
{
    return globalSettings()->file_upload_size;
}

function isValidIPv4($ip)
{
    return filter_var(trim($ip), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
}

function isValidIPv6($ip)
{
    return filter_var(trim($ip), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
}

function formatOtpTime($minutes)
{
    return gmdate('i:s', Carbon::parse($minutes)->diffInSeconds(Carbon::now())) . __(' minutes');
}

function generateBusinessReference()
{
    do {
        $randomNumber = str_pad(mt_rand(1, 999999), 7, '0', STR_PAD_LEFT);
        $exists = Business::whereReference($randomNumber)->exists();
    } while ($exists);
    return $randomNumber;
}

function encryptRSA($dataToEncrypt)
{
    $publicKey = openssl_pkey_get_public(file_get_contents(base_path() . '/../secure/rsa/public_key.pem'));
    openssl_public_encrypt($dataToEncrypt, $encryptedData, $publicKey);
    return base64_encode($encryptedData);
}

function decryptRSA($encryptedData)
{
    $privateKey = openssl_pkey_get_private(file_get_contents(base_path() . '/../secure/rsa/private_key.pem'), 'fJbL5@KNVLYP5!j@@');
    $encryptedData = base64_decode($encryptedData);
    openssl_private_decrypt($encryptedData, $decryptedData, $privateKey);
    return $decryptedData;
}

function formatTag($data)
{
    $array = json_decode($data);

    $values = array_map(function ($item) {
        return $item->value;
    }, $array);

    $result = implode(',', $values);
    return $result;
}

function sanitizeString($input, $allowedTags = null)
{
    // Strip HTML tags
    $strippedString = strip_tags($input, $allowedTags);

    // Remove newlines and collapse whitespace
    $cleanString = preg_replace('/\s+/', ' ', $strippedString);

    return $cleanString;
}

function allowedFileTypesArray()
{
    $array = json_decode(globalSettings()->files_allowed);
    $values = array_map(function ($item) {
        return config('mimes')[$item->value];
    }, $array);
    $result = $values;
    return $result;
}

function allowedImageTypesArray()
{
    $array = json_decode(globalSettings()->images_allowed);
    $values = array_map(function ($item) {
        return config('mimes')[$item->value];
    }, $array);
    $result = $values;

    return $result;
}

function allowedImageTypes()
{
    $array = json_decode(globalSettings()->images_allowed);
    $values = array_map(function ($item) {
        return config('mimes')[$item->value];
    }, $array);
    $result = implode(',', $values);

    return $result;
}

function globalSettings()
{
    return Cache::remember('app_settings', 3600, function () {
        return Settings::find(1);
    });
}

function allowedFileTypes()
{
    $array = json_decode(globalSettings()->files_allowed);
    $values = array_map(function ($item) {
        return config('mimes')[$item->value];
    }, $array);
    $result = implode(',', $values);
    return $result;
}

function allowedFileTypesDefault()
{
    $array = json_decode(globalSettings()->files_allowed);
    $values = array_map(function ($item) {
        return $item->value;
    }, $array);
    $result = implode(',', $values);
    return $result;
}

function allowedImageTypesDefault()
{
    $array = json_decode(globalSettings()->images_allowed);
    $values = array_map(function ($item) {
        return $item->value;
    }, $array);
    $result = implode(',', $values);

    return $result;
}

function updateLocale($type, $user = null)
{
    if ($type == 'admin') {
        App::setLocale(Settings::find(1)->admin_language);
    } else {
        if ($user == null) {
            App::setLocale(auth()->guard('user')->user()->language);
        } else {
            App::setLocale($user->language);
        }
    }
}

function generateOTP($business)
{
    do {
        $randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $exists = OTP::whereCode($randomNumber)->whereBusinessId($business->id)->exists();
    } while ($exists);
    $set = Settings::find(1);
    $otp = OTP::create([
        'business_id' => $business->id,
        'code' => encrypt($randomNumber),
        'expiry_time' => Carbon::now()->add($set->otp_expire_duration . ' ' . $set->otp_expire_time),
    ]);
    createAudit('Generated OTP ' . $otp->id, $business->user);
    return $randomNumber;
}

function verifyOTP($code, $business)
{
    if (OTP::whereBusinessId($business->id)->whereStatus('pending')->exists()) {
        foreach (OTP::whereBusinessId($business->id)->whereStatus('pending')->get() as $check) {
            $data[] = decrypt($check->code);
            $key[] = $check->id;
        }

        if (in_array($code, $data)) {
            $position = array_search($code, $data);
            $otp = OTP::whereId($key[$position])->first();
            if (Carbon::now() > $otp->expiry_time) {
                createAudit('Entered Expired OTP ' . $otp->id, $business->user);
                $otp->delete();
                return 'expired';
            } else {
                $otp->update(['status' => 'success']);
                createAudit('Verified OTP ' . $otp->id, $business->user);
                return 'valid';
            }
        } else {
            createAudit('Entered OTP that doesn\'t exist', $business->user);
            return 'invalid';
        }
    } else {
        createAudit('User has no pending OTP', $business->user);
        return 'invalid';
    }
}

function accessToken($business)
{
    return  $business->user->verification_code;
}

function validCountriesJson()
{
    foreach (CountryReg::whereStatus(1)->get() as $val) {
        $country[] = strtolower($val->real->iso2);
    }
    return json_encode($country);
}

function validCountries()
{
    return CountryReg::whereStatus(1)->orderBy('name', 'asc')->get();
}

function currencyFormat($value)
{
    $set = Settings::first();
    if ($set->currency_format == 'normal') {
        return $value;
    } else {
        $number = str_replace('.', '|', $value);
        $number = str_replace(',', '.', $number);
        $number = str_replace('|', ',', $number);
        return $number;
    }
}

function getDefaultLang()
{
    $locale = session()->get('locale');
    if ($locale == null || $locale == 'us') {
        $locale = "en";
    }
    return Language::whereCode($locale)->first();
}

function getLang()
{
    return Language::wherestatus(1)->get();
}

function getAllCountry()
{
    return Country::orderBy('name', 'asc')->get();
}

function hasNamedRoute($name)
{
    $routes = app('router')->getRoutes();
    return $routes->hasNamedRoute($name);
}

function getHelpCenterTopics()
{
    return Category::whereType('faq')->orderby('name', 'asc')->get();
}

function getOtherPayout()
{
    return Category::whereType('withdraw')->orderby('name', 'asc')->get();
}

function getCardCategory()
{
    return Category::whereType('giftcard_buy')->orderby('name', 'asc')->get();
}

function getPopularHelpCenter($limit = null, $skip = null)
{
    return HelpCenter::orderby('views', 'desc')->take($limit)
        ->when(($skip != null), function ($query) use ($skip) {
            return $query->skip($skip);
        })->get();
}

function getPopularBlog($limit = null, $skip = null)
{
    return Blog::orderby('views', 'desc')->with(['category'])->whereStatus(1)->take($limit)->get();
}

function getRelatedBlog($limit = null, $cat = null, $article = null)
{
    return Blog::orderby('views', 'desc')->with(['category'])->whereStatus(1)->whereCatId($cat)->where('id', '!=', $article)->take($limit)->get();
}

function estimateReadingTime($text, $wpm = 200)
{
    $totalWords = str_word_count(strip_tags($text));
    $minutes = floor($totalWords / $wpm);
    $seconds = floor($totalWords % $wpm / ($wpm / 60));
    if ($minutes == 0) {
        return $seconds . ' seconds';
    }
    return $minutes . ' minutes';
}

function getLatestBlog($limit)
{
    return Blog::orderby('created_at', 'desc')->whereStatus(1)->paginate($limit);
}

function curlContent($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function getUi()
{
    return Design::first();
}

function notifyUser($subject, $text, $link = null, $button = null, $type = null)
{
    if ($type == "general") {
        $notification = new \MBarlow\Megaphone\Types\General(
            $subject,
            $text,
            $link,
            $button,
        );
    } else if ($type == "important") {
        $notification = new \MBarlow\Megaphone\Types\Important(
            $subject,
            $text,
            $link,
            $button,
        );
    } else if ($type == "newfeature") {
        $notification = new \MBarlow\Megaphone\Types\NewFeature(
            $subject,
            $text,
            $link,
            $button,
        );
    }
    return $notification;
}

function calculateFee($num, $type, $fiat = 0, $percent = 0)
{
    if ($type == 'both') {
        $result = ($num * $percent / 100) + $fiat;
    } else if ($type == 'fiat') {
        $result = $fiat;
    } else if ($type == 'percent') {
        $result = $num * $percent / 100;
    } else if ($type == 'min' && $num <= $fiat) {
        $result = $num * $percent / 100;
    } else if ($type == 'max' && $num > $fiat) {
        $result = $num * $percent / 100;
    } else {
        $result = '0.00';
    }
    return $result;
}

function removeCommas($numberString)
{
    $numberString = str_replace(",", "", $numberString); // remove commas
    $numberFloat = floatval($numberString); // convert to float
    return round($numberFloat, 2); // round to 2 decimal places
}

function createAudit($message, $user = null, $url = null, $admin = null)
{
    Audit::create([
        'user_id' => ($user == null) ? auth()->guard('user')->user()->id : $user->id,
        'business_id' => ($user == null) ? auth()->guard('user')->user()->business_id : $user->business_id,
        'trx' => Str::random(16),
        'log' => $message,
        'admin_id' => $admin
    ]);
    return;
}

function getBlog()
{
    return Blog::whereStatus(1)->orderBy('views', 'DESC')->limit(5)->get();
}

function getBlogCat()
{
    return Category::whereType('blog')->withCount('articles')->get();
}

function getService()
{
    return Services::all();
}
function getBrands()
{
    return Brands::whereStatus(1)->get();
}
function getReview()
{
    return Review::whereStatus(1)->get();
}
function getSocial()
{
    return Social::all();
}
function getPage()
{
    return Page::whereStatus(1)->get();
}

function getTeam()
{
    return LeaderShip::whereStatus(1)->oldest()->get();
}


function randomNumber($length)
{
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }
    return $result;
}

function user_ip()
{
    return request()->header('CF-Connecting-IP')
        ?? request()->header('CF-Pseudo-IPv4') // Match the standard casing
        ?? request()->ip();
}

function UR_exists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

function number_format_short($n, $precision = 1)
{
    if ($n < 900) {
        $n_format = currencyFormat(number_format($n, $precision));
        $suffix = '';
    } else if ($n < 900000) {
        $n_format = currencyFormat(number_format($n / 1000, $precision));
        $suffix = 'K';
    } else if ($n < 900000000) {
        $n_format = currencyFormat(number_format($n / 1000000, $precision));
        $suffix = 'M';
    } else if ($n < 900000000000) {
        $n_format = currencyFormat(number_format($n / 1000000000, $precision));
        $suffix = 'B';
    } else {
        $n_format = currencyFormat(number_format($n / 1000000000000, $precision));
        $suffix = 'T';
    }
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }
    return $n_format . $suffix;
}

function number_format_short_nc($n, $precision = 1)
{
    if ($n < 900) {
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }
    return $n_format . $suffix;
}

function trxDetails($title, $details, $receipt = null)
{
    if ($receipt == null) {
        return '<div class="fs-7 d-flex justify-content-between my-4"><div>' . $title . '</div><div class="d-flex fw-bold text-break">' . $details . '</div></div><div class="separator separator-dashed"></div>';
    } else {
        return '<div class="fs-7 my-4"><div style="font-weight: bold;">' . $title . '</div><div class="fw-bold text-break">' . $details . '</div></div><div class="separator separator-dashed"></div>';
    }
}

function allGateways()
{
    return Gateway::select('main_name', 'id', 'image', 'name')->orderBy('name', 'ASC')->get();
}

function getGateways()
{
    return Gateway::whereStatus(1)->whereType(1)->orderBy('name', 'ASC')->get();
}

function getPublicImage($url)
{
    if (strpos($url, 'cloudinary') !== false) {
        return $url;
    } else {
        return url('/') . '/storage/app/' . $url;
    }
}