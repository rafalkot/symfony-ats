<?php

namespace Ats\Infrastructure\Persistence\Doctrine\Common;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use DateTimeImmutable;

class DateImmutableType extends Type
{
    const NAME = 'date_immutable';

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @param string $value
     * @return DateTimeImmutable|null
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof DateTimeImmutable) {
            return $value;
        }

        $dateTime = DateTimeImmutable::createFromFormat($platform->getDateTimeFormatString(), $value);

        if ($dateTime === false) {
            $dateTime = date_create_immutable($value);
        }

        if ($dateTime === false) {
            throw \Doctrine\DBAL\Types\ConversionException::conversionFailedFormat(
                $value,
                $this->getName(),
                $platform->getDateTimeFormatString()
            );
        }

        return $dateTime;
    }

    /**
     * @param DateTimeImmutable|null $value
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format($platform->getDateTimeFormatString());
        }

        if (!is_scalar($value)) {
            $value = sprintf('of type %s', gettype($value));
        }

        throw \Doctrine\DBAL\Types\ConversionException::conversionFailed($value, $this->getName());
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param array $fieldDeclaration The field declaration.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getDateTimeTypeDeclarationSQL($fieldDeclaration);
    }
}