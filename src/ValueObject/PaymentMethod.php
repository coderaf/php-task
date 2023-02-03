<?php

declare(strict_types=1);

namespace App\ValueObject;

enum PaymentMethod: string
{
    case BANK = 'bank';
    case CARD = 'card';
}
