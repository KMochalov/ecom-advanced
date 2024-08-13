<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class IdType extends GuidType
{
    const NAME = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Id
    {
        return !empty($value) ? new Id($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Id ? $value->getValue() : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}