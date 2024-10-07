<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    const NAME = 'email';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        return !empty($value) ? new Email($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Email ? $value->getValue() : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
