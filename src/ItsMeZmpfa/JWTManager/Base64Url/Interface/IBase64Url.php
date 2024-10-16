<?php

namespace ItsMeZmpfa\JWTManager\Base64Url\Interface;

interface IBase64Url
{
    /**
     * Encode plain data to Base64-encoded data
     */
    public function encode(string $data): string;

    /**
     * Decode Base64-encoded data to plain data
     */
    public function decode(string $data): string;
}