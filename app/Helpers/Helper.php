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

function truncateToDecimals($number, $decimals = 2, $dot = null, $seperator = null)
{
    $multiplier = pow(10, $decimals);
    return $number >= 0
        ? floor($number * $multiplier) / $multiplier
        : ceil($number * $multiplier) / $multiplier;
}

function generateBitcoinAddress()
{
    $types = ['legacy', 'segwit', 'bech32'];
    $type = $types[array_rand($types)];

    switch ($type) {
        case 'legacy':
            return '1' . randomString(33, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');

        case 'segwit':
            return '3' . randomString(33, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');

        case 'bech32':
            return 'bc1q' . randomString(38, '023456789acdefghjklmnpqrstuvwxyz');
    }
}

function generateEthereumAddress()
{
    return '0x' . randomString(40, '0123456789abcdef');
}

function generateTronAddress()
{
    return 'T' . randomString(33, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');
}

function generateStellarAddress()
{
    return 'G' . randomString(55, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567');
}

function generateSolanaAddress()
{
    return randomString(44, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');
}

function randomString($length, $characters)
{
    $max = strlen($characters) - 1;
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $characters[random_int(0, $max)];
    }
    return $result;
}

function generateTestWalletAddress($network, $token = null)
{
    $network = strtoupper($network);
    return match ($network) {
        'BTC' => generateBitcoinAddress(),
        'TBTC4' => generateBitcoinAddress(),
        'TRX' => generateTronAddress(),
        'TTRX' => generateTronAddress(),
        'XLM' => generateStellarAddress(),
        'SOL' => generateSolanaAddress(),
        'TSOL' => generateSolanaAddress(),
        'POLYGON' => generateEthereumAddress(),
        'TPOLYGON' => generateEthereumAddress(),
        default => generateEthereumAddress(),
    };
}

function verifyWalletAddress(string $address, string $token, string $network): array
{
    $address = trim($address);
    $token   = strtoupper(trim($token));
    $network = strtolower(trim($network));

    $networkAliases = [
        'btc'      => 'bitcoin',
        'eth'      => 'ethereum',
        'bnb'      => 'bsc',
        'sol'      => 'solana',
        'xrp'      => 'ripple',
        'trx'      => 'tron',
        'doge'     => 'dogecoin',
        'ltc'      => 'litecoin',
        'ada'      => 'cardano',
        'matic'    => 'polygon',
        'pol'      => 'polygon',
        'arb'      => 'arbitrum',
        'op'       => 'optimism',
    ];

    $network = $networkAliases[$network] ?? $network;

    // --- 1. Token → supported networks map ---
    $tokenNetworks = [
        'BTC'   => ['bitcoin'],
        'ETH'   => ['ethereum', 'arbitrum', 'optimism', 'base'],
        'BNB'   => ['bsc'],
        'SOL'   => ['solana'],
        'XRP'   => ['ripple'],
        'TRX'   => ['tron'],
        'DOGE'  => ['dogecoin'],
        'LTC'   => ['litecoin'],
        'ADA'   => ['cardano'],
        // EVM tokens (share Ethereum address format across EVM chains)
        'USDT'  => ['ethereum', 'bsc', 'tron', 'solana', 'arbitrum', 'optimism', 'polygon'],
        'USDC'  => ['ethereum', 'bsc', 'solana', 'arbitrum', 'optimism', 'polygon', 'base', 'tron'],
        'DAI'   => ['ethereum', 'bsc', 'polygon', 'arbitrum', 'optimism'],
        'MATIC' => ['polygon', 'ethereum'],
        'LINK'  => ['ethereum', 'bsc', 'polygon'],
        'UNI'   => ['ethereum'],
        'WETH'  => ['ethereum', 'arbitrum', 'optimism', 'polygon', 'base'],
    ];

    // --- 2. Check token is recognised ---
    if (!isset($tokenNetworks[$token])) {
        return ['valid' => false, 'reason' => "Unsupported token: {$token}"];
    }

    // --- 3. Check network supports this token ---
    if (!in_array($network, $tokenNetworks[$token], true)) {
        $supported = implode(', ', $tokenNetworks[$token]);
        return [
            'valid'  => false,
            'reason' => "{$token} is not supported on {$network}. Supported networks: {$supported}",
        ];
    }

    // --- 4. Validate address format for the network ---
    return match (true) {

        // EVM-compatible (Ethereum, BSC, Polygon, Arbitrum, Optimism, Base)
        in_array($network, ['ethereum', 'bsc', 'polygon', 'arbitrum', 'optimism', 'base'], true)
        => validateEVMAddress($address),

        $network === 'bitcoin'   => validateBitcoinAddress($address),
        $network === 'solana'    => validateSolanaAddress($address),
        $network === 'tron'      => validateTronAddress($address),
        $network === 'ripple'    => validateRippleAddress($address),
        $network === 'dogecoin'  => validateDogecoinAddress($address),
        $network === 'litecoin'  => validateLitecoinAddress($address),
        $network === 'cardano'   => validateCardanoAddress($address),

        default => ['valid' => false, 'reason' => "No validator implemented for network: {$network}"],
    };
}

// ---------------------------------------------------------------------------
// Network-specific validators
// ---------------------------------------------------------------------------

function validateEVMAddress(string $address): array
{
    // Must start with 0x + exactly 40 hex characters
    if (!preg_match('/^0x[0-9a-fA-F]{40}$/', $address)) {
        return ['valid' => false, 'reason' => 'Invalid EVM address format (expected 0x + 40 hex chars)'];
    }

    // EIP-55 checksum validation (mixed-case addresses)
    if ($address !== strtolower($address) && $address !== strtoupper("0x") . strtoupper(substr($address, 2))) {
        if (!verifyEIP55Checksum($address)) {
            return ['valid' => false, 'reason' => 'EIP-55 checksum mismatch'];
        }
    }

    return ['valid' => true, 'reason' => 'Valid EVM address'];
}

function verifyEIP55Checksum(string $address): bool
{
    // If keccak256 is unavailable, skip checksum and trust regex alone.
    // PHP does not ship keccak256 (sha3-256 is NOT equivalent — different padding),
    // and hash() throws ValueError on unsupported algorithms in PHP 8.1+.
    if (!in_array('keccak256', hash_algos(), true)) {
        return true;
    }

    $address = substr($address, 2); // strip 0x
    $hash    = hash('keccak256', strtolower($address));

    for ($i = 0; $i < 40; $i++) {
        $char     = $address[$i];
        $hashChar = hexdec($hash[$i]);
        if (ctype_alpha($char)) {
            if (($hashChar >= 8 && strtoupper($char) !== $char) ||
                ($hashChar < 8 && strtolower($char) !== $char)
            ) {
                return false;
            }
        }
    }
    return true;
}

function validateBitcoinAddress(string $address): array
{
    // Legacy P2PKH: starts with 1, 25-34 chars
    if (preg_match('/^1[1-9A-HJ-NP-Za-km-z]{24,33}$/', $address)) {
        return ['valid' => true, 'reason' => 'Valid Bitcoin Legacy (P2PKH) address'];
    }

    // P2SH: starts with 3, 25-34 chars
    if (preg_match('/^3[1-9A-HJ-NP-Za-km-z]{24,33}$/', $address)) {
        return ['valid' => true, 'reason' => 'Valid Bitcoin P2SH address'];
    }

    // Bech32 Native SegWit: starts with bc1q or bc1p (Taproot)
    if (preg_match('/^bc1[0-9a-z]{6,87}$/', strtolower($address))) {
        return ['valid' => true, 'reason' => 'Valid Bitcoin Bech32 (SegWit/Taproot) address'];
    }

    return ['valid' => false, 'reason' => 'Invalid Bitcoin address format'];
}

function validateSolanaAddress(string $address): array
{
    // Base58, 32–44 characters (no 0, O, I, l)
    if (!preg_match('/^[1-9A-HJ-NP-Za-km-z]{32,44}$/', $address)) {
        return ['valid' => false, 'reason' => 'Invalid Solana address (expected Base58, 32-44 chars)'];
    }
    return ['valid' => true, 'reason' => 'Valid Solana address'];
}

function validateTronAddress(string $address): array
{
    // Base58Check, starts with T, exactly 34 chars
    if (!preg_match('/^T[1-9A-HJ-NP-Za-km-z]{33}$/', $address)) {
        return ['valid' => false, 'reason' => 'Invalid TRON address (must start with T, 34 chars)'];
    }
    return ['valid' => true, 'reason' => 'Valid TRON address'];
}

function validateRippleAddress(string $address): array
{
    // Base58, starts with r, 25-35 chars
    if (!preg_match('/^r[1-9A-HJ-NP-Za-km-z]{24,34}$/', $address)) {
        return ['valid' => false, 'reason' => 'Invalid XRP address (must start with r, 25-35 chars)'];
    }
    return ['valid' => true, 'reason' => 'Valid XRP Ledger address'];
}

function validateDogecoinAddress(string $address): array
{
    // Starts with D, 26-34 chars
    if (!preg_match('/^D[1-9A-HJ-NP-Za-km-z]{25,33}$/', $address)) {
        return ['valid' => false, 'reason' => 'Invalid Dogecoin address'];
    }
    return ['valid' => true, 'reason' => 'Valid Dogecoin address'];
}

function validateLitecoinAddress(string $address): array
{
    // Legacy: starts with L, P2SH: starts with M, Bech32: starts with ltc1
    if (preg_match('/^[LM][1-9A-HJ-NP-Za-km-z]{25,33}$/', $address)) {
        return ['valid' => true, 'reason' => 'Valid Litecoin address'];
    }
    if (preg_match('/^ltc1[0-9a-z]{6,87}$/', strtolower($address))) {
        return ['valid' => true, 'reason' => 'Valid Litecoin Bech32 address'];
    }
    return ['valid' => false, 'reason' => 'Invalid Litecoin address format'];
}

function validateCardanoAddress(string $address): array
{
    // Shelley: starts with addr1, Bech32, 58-103 chars
    if (preg_match('/^addr1[0-9a-z]{50,100}$/', strtolower($address))) {
        return ['valid' => true, 'reason' => 'Valid Cardano Shelley address'];
    }
    // Byron Legacy: starts with Ae2 or DdzFF
    if (preg_match('/^(Ae2|DdzFF)[1-9A-HJ-NP-Za-km-z]{50,}$/', $address)) {
        return ['valid' => true, 'reason' => 'Valid Cardano Byron (Legacy) address'];
    }
    return ['valid' => false, 'reason' => 'Invalid Cardano address format'];
}

function balanceCapture($balance, $trx = null, $crypto, $type, $order)
{
    if ($balance) {
        \App\Models\BalanceCapture::create([
            'balance_id' => $balance->id,
            'amount' => $balance->amount,
            'hold' => ($crypto == true) ? 0 : $balance->hold,
            'user_id' => $balance->user_id,
            'business_id' => $balance->business_id,
            'currency' => $balance->country_id,
            'trx_id' => $trx,
        ]);
    }
}

function logBalance($balance, $amount, $trx_type, $trx = null, $type, $crypto = false, $locked = 0)
{
    //Before Update
    balanceCapture((($crypto == true) ? \App\Models\CryptoBalance::whereId($balance)->first() : \App\Models\Balance::whereId($balance)->first()), $trx, $crypto, $type, 0);

    \App\Models\BalanceLog::create([
        'balance_id' => $balance,
        'amount' => $amount,
        'trx_type' => $trx_type,
        'trx_id' => $trx,
        'type' => $type,
        'crypto' => $crypto,
        'currency_id' => ($crypto == true) ? \App\Models\CryptoBalance::whereId($balance)->first()?->country_id : \App\Models\Balance::whereId($balance)->first()?->country_id,
    ]);

    //After Balance Update
    balanceCapture((($crypto == true) ? \App\Models\CryptoBalance::whereId($balance)->first() : \App\Models\Balance::whereId($balance)->first()), $trx, $crypto, $type, 1);
}

function getAllCryptoCurrencies()
{
    return \App\Models\CryptoCurrencies::orderby('country_id', 'asc')->get();
}

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
        $randomNumber = str_pad(random_int(0, 9999999), 7, '0', STR_PAD_LEFT);
        $exists = Business::whereReference($randomNumber)->exists();
    } while ($exists);
    return $randomNumber;
}

function rsaKeyPath(string $file): string
{
    return config('services.rsa.path') . '/' . $file;
}

function encryptRSA($dataToEncrypt)
{
    $publicKey = openssl_pkey_get_public(file_get_contents(rsaKeyPath('public_key.pem')));

    if (! openssl_public_encrypt($dataToEncrypt, $encryptedData, $publicKey)) {
        throw new RuntimeException('RSA encryption failed: ' . openssl_error_string());
    }

    return base64_encode($encryptedData);
}

function decryptRSA($encryptedData)
{
    $privateKey = openssl_pkey_get_private(
        file_get_contents(rsaKeyPath('private_key.pem')),
        config('services.rsa.passphrase')
    );

    if (! openssl_private_decrypt(base64_decode($encryptedData), $decryptedData, $privateKey)) {
        throw new RuntimeException('RSA decryption failed: ' . openssl_error_string());
    }

    return $decryptedData;
}

function generateRandomCode()
{
    $segments = [];
    for ($i = 0; $i < 4; $i++) {
        $segments[] = randomString(4, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    }
    $code = implode('-', $segments);
    return $code;
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
        $randomNumber = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
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

function calculateFee(float $num, string $type, $fiat = 0, $percent = 0)
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

function tierPricing(float $amount, array $tier_levels): array
{
    foreach ($tier_levels as $tier) {
        $min = (float) $tier['min'];
        $max = ($tier['max'] !== '' && $tier['max'] !== null)
            ? (float) $tier['max']
            : null;

        $inRange = $amount >= $min && ($max === null || $amount <= $max);

        if ($inRange) {
            $percent = (float) $tier['percent'];
            $fiat    = (float) $tier['flat'];

            return [
                'flat'    => $fiat,
                'percent' => $percent,
                'fee'     => round(($amount * $percent / 100) + $fiat, 2),
            ];
        }
    }

    return [
        'fiat'    => 0,
        'percent' => 0,
        'fee'     => 0,
    ];
}

function removeCommas(string $numberString)
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
        $result .= random_int(0, 9);
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