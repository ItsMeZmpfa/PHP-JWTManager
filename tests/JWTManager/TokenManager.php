<?php

namespace ItsMeZmpfa\tests\JWTManager;

use ItsMeZmpfa\JWTManager\Parser;
use ItsMeZmpfa\JWTManager\Algorithms\Hmac\HS512;
use ItsMeZmpfa\JWTManager\Algorithms\Keys\HmacKey;
use ItsMeZmpfa\JWTManager\Exception\InvalidTokenException;
use ItsMeZmpfa\JWTManager\Generator;

class TokenManager extends TestCase
{
    /**
     *
     */
    public function test_simple_example()
    {
        $key = new HmacKey('12345678901234567890123456789012');
        $signer = new HS512($key);

        // Generate a token
        $generator = new Generator($signer);
        $jwt = $generator->generate(['id' => 13, 'is-admin' => true]);
        var_dump($jwt);

        // Parse the token
        $parser = new Parser($signer);
        $claims = $parser->parse($jwt);

        $this->assertEquals(['id' => 13, 'is-admin' => true], $claims);
    }
}