<?php
namespace ItsMeZmpfa\tests\JWTManager;
use Dotenv\Dotenv;
use ItsMeZmpfa\JWTManager\Exception\JsonEncodingException;
use ItsMeZmpfa\tests\JWTManager\TestJWTManager;

class TestManager extends \PHPUnit\Framework\TestCase
{


    /**
     * @throws JsonEncodingException
     */
    public function testgenerate()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

       $jwt = TestJWTManager::generateJWT(['id' => 13, 'is-admin' => true]);
       $claims = TestJWTManager::parserJWT($jwt);

        $this->assertEquals(['id' => 13, 'is-admin' => true], $claims);
    }
}