<?php

namespace Module\Balance\Domain;

interface BalanceRepository
{
    public function save(Balance $balance): void;
}
