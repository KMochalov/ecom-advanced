<?php

declare(strict_types=1);

namespace App\Auth\Tests\Unit\Entity\User;

use PHPUnit\Framework\TestCase;
use App\Auth\Entity\User\Status;

/**
 * @covers \App\Auth\Entity\User\Status
 */
class StatusTest extends TestCase
{
    public function testInActiveStatus(): void
    {
        $status = Status::inActive();

        $this->assertFalse($status->isActive());
        $this->assertFalse($status->getValue());
    }

    public function testActiveStatus(): void
    {
        $status = Status::active();

        $this->assertTrue($status->isActive());
        $this->assertTrue($status->getValue());
    }

    public function testMakeActive(): void
    {
        $status = Status::inActive();
        $status->makeActive();

        $this->assertTrue($status->isActive());
        $this->assertTrue($status->getValue());
    }

    public function testMakeInActive(): void
    {
        $status = Status::active();
        $status->makeInActive();

        $this->assertFalse($status->isActive());
        $this->assertFalse($status->getValue());
    }
}
