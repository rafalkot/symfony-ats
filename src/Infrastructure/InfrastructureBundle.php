<?php

namespace Ats\Infrastructure;


use Ats\Infrastructure\Persistence\Doctrine\Common\DatetimeImmutableType;
use Ats\Infrastructure\Persistence\Doctrine\Project\ProjectIdType;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;

class InfrastructureBundle extends Bundle
{

    public function boot()
    {
        parent::boot();

        if (!Type::hasType(DatetimeImmutableType::NAME)) {
            Type::addType(DatetimeImmutableType::NAME, DatetimeImmutableType::class);
        }

        if (!Type::hasType(ProjectIdType::NAME)) {
            Type::addType(ProjectIdType::NAME, ProjectIdType::class);
        }
    }
}