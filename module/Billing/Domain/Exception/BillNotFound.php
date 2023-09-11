<?php

namespace Module\Billing\Domain\Exception;

use Module\Expense\Domain\Exception\Throwable;

class BillNotFound extends \Exception
{
    private function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function byReference(string $reference): BillNotFound
    {
        return new self('Bill '.$reference.' not found', 404);
    }
}
