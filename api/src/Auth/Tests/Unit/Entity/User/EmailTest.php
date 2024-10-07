<?php

namespace App\Auth\Tests\Unit\Entity\User;

use App\Entity\Email;
use DomainException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Auth\Entity\User\Email
 */
class EmailTest extends TestCase
{
    public function testSuccess(): void
    {
        $email = new Email($value = 'stepan@mail.ru');
        $this->assertEquals($value, $email->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(DomainException::class);
        new Email('asdddasd');
    }

    public function testCase(): void
    {
        $email = new Email($value = 'StepaN@mail.ru');
        $this->assertEquals(mb_strtolower($value), $email->getValue());
    }


}
