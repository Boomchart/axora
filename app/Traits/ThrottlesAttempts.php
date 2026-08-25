<?php

namespace App\Traits;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 * Shared attempt limiting for anything a caller can guess: passwords,
 * emailed codes and 2FA pins.
 *
 * The knobs below are methods rather than properties on purpose. PHP treats a
 * class that redeclares a trait property with a different default as a fatal
 * composition error, so a property would be un-overridable in practice.
 */
trait ThrottlesAttempts
{
    /**
     * Failed attempts allowed against a single target before it locks.
     */
    protected function maxAttemptsPerTarget()
    {
        return 5;
    }

    /**
     * Failed attempts allowed from one IP across every target, so that a
     * guesser cannot simply spread the load over many accounts.
     */
    protected function maxAttemptsPerIp()
    {
        return 20;
    }

    /**
     * How long a burst of failed attempts is remembered, in seconds.
     */
    protected function attemptDecaySeconds()
    {
        return 300;
    }

    /**
     * Whether the per-target counter is also scoped to the caller's IP.
     *
     * True for login screens, where anyone can name any account and an
     * IP-wide key would let them lock a victim out on purpose. Override to
     * false once the target is the session's own account (code and 2FA
     * checks), where an IP-scoped key would just invite the guesser to
     * rotate addresses.
     */
    protected function scopesAttemptsToIp()
    {
        return true;
    }

    /**
     * Whether a lockout raises Laravel's auth Lockout event. Only login
     * screens should; the event means "locked out of signing in".
     */
    protected function firesLockoutEvent()
    {
        return false;
    }

    protected function attemptThrottleKeys($purpose, $target)
    {
        $ip = request()->ip();
        $target = Str::transliterate(Str::lower(trim((string) $target)));

        return [
            $purpose . '|' . $target . ($this->scopesAttemptsToIp() ? '|' . $ip : '') => $this->maxAttemptsPerTarget(),
            $purpose . '|ip|' . $ip => $this->maxAttemptsPerIp(),
        ];
    }

    /**
     * Seconds left on the lockout, or null when the attempt may proceed.
     */
    protected function attemptLockout($purpose, $target)
    {
        $wait = null;

        foreach ($this->attemptThrottleKeys($purpose, $target) as $key => $maxAttempts) {
            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                $wait = max($wait, RateLimiter::availableIn($key));
            }
        }

        if ($wait === null) {
            return null;
        }

        Log::warning('Attempt throttled', [
            'purpose' => $purpose,
            'target' => hash('sha256', (string) $target),
            'ip' => request()->ip(),
        ]);

        if ($this->firesLockoutEvent()) {
            event(new Lockout(request()));
        }

        return $wait;
    }

    protected function attemptLockoutMessage($seconds)
    {
        return __('Too many attempts. Please try again in :seconds seconds', ['seconds' => $seconds]);
    }

    protected function recordFailedAttempt($purpose, $target)
    {
        foreach (array_keys($this->attemptThrottleKeys($purpose, $target)) as $key) {
            RateLimiter::hit($key, $this->attemptDecaySeconds());
        }
    }

    protected function clearAttempts($purpose, $target)
    {
        foreach (array_keys($this->attemptThrottleKeys($purpose, $target)) as $key) {
            RateLimiter::clear($key);
        }
    }
}
