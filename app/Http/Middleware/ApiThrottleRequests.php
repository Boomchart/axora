<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class ApiThrottleRequests extends ThrottleRequests
{
    protected function addHeaders(Response $response, $maxAttempts, $remainingAttempts, $retryAfter = null)
    {
        $headers = [
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => $remainingAttempts,
            'X-RateLimit-Reset' => $this->availableAt($retryAfter ?? 60),
        ];

        if (! is_null($retryAfter)) {
            $headers['Retry-After'] = $retryAfter;
        }

        $response->headers->add($headers);

        return $response;
    }

    protected function availableAt($delay = 0)
    {
        return now()->addSeconds($delay)->getTimestamp();
    }
}
