<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Doctrine\DBAL\Types\GuidType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Entity\Id;

class IdType extends GuidType
{
    const NAME = 'user_id';

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