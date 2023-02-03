<?php

declare(strict_types=1);

namespace App\Request;

interface RefererIpProviderInterface
{
    public function provide(): ?string;
}