<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\RequestStack;

readonly class RefererIpProvider implements RefererIpProviderInterface
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function provide(): ?string
    {
        return $this->requestStack->getMainRequest()?->getClientIp();
    }
}