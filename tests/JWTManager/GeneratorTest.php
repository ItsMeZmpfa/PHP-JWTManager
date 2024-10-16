<?php

namespace ItsMeZmpfa\tests\JWTManager;

use ItsMeZmpfa\JWTManager\Algorithms\Hmac\HS512;
use ItsMeZmpfa\JWTManager\Algorithms\ISigner;
use ItsMeZmpfa\JWTManager\Algorithms\Keys\HmacKey;
use ItsMeZmpfa\JWTManager\Base64Url\Base64Url;
use ItsMeZmpfa\JWTManager\Exception\JsonEncodingException;
use ItsMeZmpfa\JWTManager\Exception\SigningException;
use ItsMeZmpfa\JWTManager\Generator;
use ItsMeZmpfa\JWTManager\Json\JsonParser;

class GeneratorTest extends TestCase
{
    protected ISigner $signer;

    public function setUp(): void
    {
        parent::setUp();

        $this->signer = new HS512(new HmacKey('12345678901234567890123456789012'));
    }

    /**
     * @throws JsonEncodingException
     * @throws SigningException
     */
    public function test_generate_with_sample_claims_it_should_generate_jwt()
    {
        $generator = new Generator($this->signer);
        $jwt = $generator->generate($this->sampleClaims);

        $this->assertEquals($this->sampleJwt, $jwt);
    }

    public function test_set_and_get_signer()
    {
        $generator = new Generator($this->signer);

        $this->assertSame($this->signer, $generator->getSigner());
    }

    public function test_set_and_get_json_parser()
    {
        $jsonParser = new JsonParser();
        $generator = new Generator($this->signer, $jsonParser);

        $this->assertSame($jsonParser, $generator->getJsonParser());
    }

    public function test_set_and_get_base64_parser()
    {
        $base64Parser = new Base64Url();
        $generator = new Generator($this->signer, null, $base64Parser);

        $this->assertSame($base64Parser, $generator->getBase64Parser());
    }
}