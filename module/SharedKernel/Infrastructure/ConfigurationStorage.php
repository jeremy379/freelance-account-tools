<?php

namespace Module\SharedKernel\Infrastructure;

use Module\SharedKernel\Domain\Configuration;

class ConfigurationStorage implements Configuration
{
    public function loadKeyFile(string $key): array
    {
        $config = config($key);

        if(!is_array($config)) {
            throw new \InvalidArgumentException('Configuration key is invalid. An array is expected');
        }

        return $config;
    }
}
