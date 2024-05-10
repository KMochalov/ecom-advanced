<?php

namespace App\Auth\Tests\Unit\Entity\User;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Services\Hasher;
use App\Auth\Services\Tokenizer;
use PHPUnit\Framework\TestCase;
use App\Auth\Entity\User\User;
use DateTimeImmutable;
use App\Auth\Entity\User\Status;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Auth\Entity\User\User
 */
class UserTest extends TestCase
{
    public function testSuccessByEmail(): void
    {
        $hasher = new Hasher();
        $tokinizer = new Tokenizer();

        $user = User::requestRegisterByEmail(
            $id = Id::generate(),
            $email = new Email($emailValue = 'asdasd@mail.ru'),
            $date = new DateTimeImmutable(),
            $passwordHash = $hasher->hash($password = 'asdasdasd'),
            $token = $tokinizer->tokenize($date)
        );

        self::assertEquals($id->getValue(), $user->getId()->getValue());
        self::assertEquals($email->getValue(), $user->getEmail()->getValue());
        self::assertEquals($passwordHash, $user->getPasswordHash());
        self::assertEquals($token->getValue(), $user->getConfirmToken()->getValue());
        self::assertEquals($token->expireAt(), $user->getConfirmToken()->expireAt());
    }
}
