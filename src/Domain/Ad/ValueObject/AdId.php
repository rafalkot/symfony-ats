<?php

declare(strict_types=1);

namespace Ats\Domain\Ad\ValueObject;

use Ats\Domain\Common\ValueObject\Id;
use Ats\Domain\Common\ValueObject\Uuid;

class AdId extends Id
{
    /**
     * @return AdId
     */
    public static function generate(): AdId
    {
        return new self(Uuid::generate());
    }
}
