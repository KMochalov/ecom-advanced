<?php

declare(strict_types=1);

namespace Test\functional\Http\Action;

use Test\BasicTestCase;

/** @coversNothing  */
class HomeActionTest extends BasicTestCase
{
    public function testSuccess()
    {
        $response = $this->app()->handle(self::json('GET', '/'));

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('["asdasdasd"]', (string)$response->getBody());
        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}
