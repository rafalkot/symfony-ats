<?php

namespace Ats\Infrastructure\Persistence\Doctrine\Ad;

use Ats\Domain\Ad\ValueObject\AdId;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class AdIdType extends GuidType
{
    const NAME = 'ad_id';

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
     * @return AdId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new AdId($value);
    }

    /**
     * @param AdId $value
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->id();
    }
}