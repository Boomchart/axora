<?php

namespace App\Services\Reloadly;

use RuntimeException;
use Throwable;

class Exception extends RuntimeException
{
    public function __construct(
        string $message = '',
        int $code = 0,
        protected ?array $errorBody = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function errorBody(): ?array
    {
        return $this->errorBody;
    }
}
