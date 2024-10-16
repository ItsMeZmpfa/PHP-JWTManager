<?php

namespace ItsMeZmpfa\tests\JWTManager\Algorithm\Hmac;

use ItsMeZmpfa\JWTManager\Algorithms\Hmac\HS512;
use ItsMeZmpfa\JWTManager\Algorithms\Keys\HmacKey;
use ItsMeZmpfa\JWTManager\Exception\InvalidSignatureException;
use Throwable;

class HS512Test extends \ItsMeZmpfa\tests\JWTManager\TestCase
{
    protected HmacKey $key;

    public function setUp(): void
    {
        parent::setUp();

        $this->key = new HmacKey('12345678901234567890123456789012');
    }

    /**
     * @throws Throwable
     */
    public function test_sign_and_verify_it_should_sign_and_verify_with_the_key()
    {
        $plain = 'Text';

        $signer = new HS512($this->key);
        $signature = $signer->sign($plain);
        $signer->verify($plain, $signature);

        $this->assertTrue(true);
    }

    /**
     * @throws Throwable
     */
    public function test_sign_and_verify_it_should_fail_with_different_plains()
    {
        $signer = new HS512($this->key);
        $signature = $signer->sign('Text');

        $this->expectException(InvalidSignatureException::class);
        $signer->verify('Different!', $signature);
    }
}