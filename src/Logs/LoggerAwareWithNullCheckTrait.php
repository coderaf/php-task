<?php

declare(strict_types=1);

namespace App\Logs;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

trait LoggerAwareWithNullCheckTrait
{
    use LoggerAwareTrait;

    public function getLogger(): ?LoggerInterface
    {
        if ($this->logger === null) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }
}
