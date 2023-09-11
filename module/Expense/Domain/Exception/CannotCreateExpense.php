<?php

namespace Module\Expense\Domain\Exception;

class CannotCreateExpense extends \Exception
{
    private function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function referenceAlreadyExists(string $reference): CannotCreateExpense
    {
        return new self('The reference '.$reference.' already exists', 400);
    }
}
