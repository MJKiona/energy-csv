<?php

declare(strict_types=1);

namespace Kiona\Data;

final class Formatter
{
    public static function toDecimal(int $number): string
    {
        return number_format($number/100, 2, '.', '');
    }
}
