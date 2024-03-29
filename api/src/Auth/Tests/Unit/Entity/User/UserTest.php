<?php

namespace App\Auth\Tests\Unit\Entity\User;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Serivces\Hasher;
use App\Auth\Serivces\Tokenizer;
use PHPUnit\Framework\TestCase;
use App\Auth\Entity\User\User;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Auth\Entity\User\User
 */
class UserTest extends TestCase
{
    public function testSuccess(): void
    {
        $hasher = new Hasher();
        $tokinizer = new Tokenizer();
        $user = new User(
            $id = Id::generate(),
            $email = new Email($emailValue = 'asdasd@mail.ru'),
            $date = new DateTimeImmutable(),
            $passwordHash = $hasher->hash($password = 'asdasdasd'),
            $token = $tokinizer->tokenize($date)
        );

        self::assertEquals($id->getValue(), $user->getId()->getValue());
        self::assertEquals($email->getValue(), $user->getEmail()->getValue());
        self::assertEquals($passwordHash, $user->getPasswordHash());
        self::assertEquals($token->getValue(), $user->getToken()->getValue());
        self::assertEquals($token->expireAt(), $user->getToken()->expireAt());
    }
}