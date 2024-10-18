<?php

namespace App\Auth\Tests\Unit\Entity\User;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Entity\Id;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

/**
 * @covers \App\Auth\Entity\User\Id
 */
class IdTest extends TestCase
{
    public function testSuccess(): void
    {
        $id = new Id($value = Uuid::uuid4()->toString());
        $this->assertEquals($value,$id->getValue());
        Assert::uuid($id->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $id = new Id($value = 'asdasdasd');
    }

    public function testCase(): void
    {
        $id = Uuid::uuid4()->toString();
        $id = mb_strtoupper($id);
        $idObj = new Id($id);
        $this->assertEquals(mb_strtolower($id), $idObj->getValue());
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $id = new Id('');
    }
}