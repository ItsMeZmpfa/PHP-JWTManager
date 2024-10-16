<?php

namespace ItsMeZmpfa\tests\JWTManager;

use Throwable;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected array $sampleClaims = [];

    protected string $sampleJwt;

    /**
     * @throws Throwable
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->sampleClaims = [
            "sub" => 666,
            "exp" => 1573166463 + 60 * 60 * 24,
            "nbf" => 1573166463,
            "iat" => 1573166463,
            "iss" => 'Test!',
        ];


        $this->sampleJwt = join('.', [
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9',
            'eyJzdWIiOjY2NiwiZXhwIjoxNTczMjUyODYzLCJuYmYiOjE1NzMxNjY0NjMsImlhdCI6MTU3MzE2NjQ2MywiaXNzIjoiVGVzdCEifQ',
            'HyEtz85dQqE7n_aFHbi2svS2dUGREHD7OTAhZEiwM2VP85JqYFaqcIofzPuFNy6huDDlNcyfFLZ6R7CngIqXlw',
        ]);
    }
}