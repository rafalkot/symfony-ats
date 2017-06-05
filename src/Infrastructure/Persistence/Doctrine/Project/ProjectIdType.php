<?php

namespace Ats\Infrastructure\Persistence\Doctrine\Project;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ats\Domain\Project\ValueObject\ProjectId;

class ProjectIdType extends Type
{
    const NAME = 'project_id';

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @param string $value
     * @return ProjectId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ProjectId($value);
    }

    /**
     * @param ProjectId $value
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getId();
    }
}