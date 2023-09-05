<?php

namespace Module\SharedKernel\Domain;

interface Configuration
{
    public function loadKeyFile(string $key): array;
}
