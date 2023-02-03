<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Uid\Uuid;

class UuidUniqueIdProvider implements RequestUniqueIdProviderInterface
{
    public function getUniqueId(): string
    {
        return Uuid::v4()->toRfc4122();
    }
}