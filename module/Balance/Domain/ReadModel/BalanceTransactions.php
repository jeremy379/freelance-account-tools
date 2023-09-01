<?php

namespace Module\Balance\Domain\ReadModel;

use Module\Balance\Domain\Balance;
use Webmozart\Assert\Assert;

class BalanceTransactions implements \Countable
{
    /**
     * @param array<Balance> $transactions
     */
    public function __construct(private array $transactions = [])
    {
        Assert::allIsInstanceOf($this->transactions, Balance::class);
    }

    /**
     * @return Balance[]
     */
    public function transactions(): array
    {
        return $this->transactions;
    }

    public function count(): int
    {
        return count($this->transactions());
    }
}
