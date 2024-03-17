<?php

namespace App\Auth\Tests\Unit\Entity\User;

use App\Auth\Entity\User\Token;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Auth\Entity\User\Token
 */
class TokenTest extends TestCase
{
    public function testSuccess(): void
    {
        $now = new DateTimeImmutable();
        $expires = $now->modify('+12 hour');
        $tokenValue = Uuid::uuid4()->toString();
        $token = new Token($tokenValue, $now->modify('+12 hour'));
        self::assertEquals($tokenValue, $token->getValue());
        self::assertEquals($expires, $token->expireAt());
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $now = new DateTimeImmutable();
        $expires = $now->modify('+12 hour');

        $token = new Token('$tokenValue', $now->modify('+12 hour'));
    }

}