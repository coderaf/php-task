<?php

declare(strict_types=1);

namespace App\Request;

interface RequestUniqueIdProviderInterface
{
    public function getUniqueId(): string;
}