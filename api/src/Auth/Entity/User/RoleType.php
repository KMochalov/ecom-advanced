<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Auth\Entity\User\Role;

class RoleType extends StringType
{
    const NAME = 'user_role';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Role
    {
        return !empty($value) ? new Role($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Role ? $value->getRole() : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}