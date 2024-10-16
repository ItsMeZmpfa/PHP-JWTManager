<?php

namespace ItsMeZmpfa\JWTManager;


use ItsMeZmpfa\JWTManager\Exception\JsonEncodingException;

class JWTManager
{


    /**
     * @var Core|null
     */
    protected static ?Core $core = null;


    /**
     * @throws JsonEncodingException
     */
    public static function generateJWT(array $payload): string
    {
        return static::core()->generateJWT($payload);
    }

    public static function parseJWT(string $jwt): array
    {

        return static::core()->parseJWT($jwt);
    }

    /**
     * Returns the router instance
     *
     * @return Core
     */
    public static function core(): Core
    {
        if (static::$core === null) {
            static::$core = new Core();
        }

        return static::$core;
    }
}