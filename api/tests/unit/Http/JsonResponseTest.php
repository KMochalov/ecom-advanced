<?php

namespace Test\unit\Http;

use PHPUnit\Framework\TestCase;
use App\Http\JsonResponse;

/** @covers \App\Http\JsonResponse */
class JsonResponseTest extends TestCase
{
    /** @dataProvider getData */
    public function testResponse($input, $expected)
    {
        $response = new JsonResponse($input);
        $this->assertEquals($expected, (string)$response->getBody());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(200, $response->getStatusCode());
    }

    public static function getData(): array
    {
        $obj = new \stdClass();
        $obj->str = 'string';
        $obj->int = 22;
        $obj->null = null;

        return [
            'empty' => ['', '""'],
            'int' => [13, "13"],
            'null' => [null, 'null'],
            'obj' => [$obj, '{"str":"string","int":22,"null":null}']
        ];
    }
}
