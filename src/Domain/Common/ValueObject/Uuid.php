<?php

declare(strict_types=1);

namespace Ats\Domain\Common\ValueObject;

class Uuid
{
    public static function generate(): string
    {
        // todo implement ramsey uuid
        return uniqid();
    }
}