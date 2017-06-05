<?php

declare(strict_types=1);

namespace Ats\Domain\Project\ValueObject;

use Ats\Domain\Common\ValueObject\Id;
use Ats\Domain\Common\ValueObject\Uuid;

class ProjectId extends Id
{
    /**
     * @return ProjectId
     */
    public static function generate(): ProjectId
    {
        return new self(Uuid::generate());
    }
}
