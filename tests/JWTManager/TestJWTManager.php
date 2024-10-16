<?php

namespace ItsMeZmpfa\tests\JWTManager;

use Dotenv\Dotenv;
use ItsMeZmpfa\JWTManager\Exception\JsonEncodingException;
use ItsMeZmpfa\JWTManager\JWTManager;

class TestJWTManager extends JWTManager
{

        public function __construct()
        {

        }

    /**
     * @throws JsonEncodingException
     */
    public static function createJwt(array $testJwt): string
    {
          $jwt = static::generateJWT($testJwt);

          return $jwt;
    }

    public static function parserJWT(string $jwt):array
    {
        try{
            static::parseJWT($jwt);
        }catch (JsonEncodingException $e){

        }
        return static::parseJwt($jwt);
    }

}