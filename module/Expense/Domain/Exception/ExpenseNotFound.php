<?php

namespace Module\Expense\Domain\Exception;

class ExpenseNotFound extends \Exception
{
    private function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function byReference(string $reference): ExpenseNotFound
    {
        return new self('Expense '.$reference.' not found', 404);
    }
}
