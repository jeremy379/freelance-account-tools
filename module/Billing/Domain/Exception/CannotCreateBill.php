<?php

namespace Module\Billing\Domain\Exception;

use Module\Expense\Domain\Exception\Throwable;

class CannotCreateBill extends \Exception
{
    private function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function referenceAlreadyExists(string $reference): CannotCreateBill
    {
        return new self('The reference '.$reference.' already exists', 400);
    }
}
