<?php

namespace ItsMeZmpfa\JWTManager\Json\Interface;

use ItsMeZmpfa\JWTManager\Exception\JsonDecodingException;
use ItsMeZmpfa\JWTManager\Exception\JsonEncodingException;

interface IJsonParser
{
    /**
     * Encode array data to JSON string
     * @throws JsonEncodingException
     */
    public function encode(array $data): string;

    /**
     * Decode JSON string to array data
     * @throws JsonDecodingException
     */
    public function decode(string $json): array;
}