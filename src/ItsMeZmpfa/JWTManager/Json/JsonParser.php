<?php

namespace ItsMeZmpfa\JWTManager\Json;

use ItsMeZmpfa\JWTManager\Exception\JsonDecodingException;
use ItsMeZmpfa\JWTManager\Exception\JsonEncodingException;
use ItsMeZmpfa\JWTManager\Json\Interface\IJsonParser;


class JsonParser implements IJsonParser
{

    /**
     * @inheritdoc
     *
     */
    public function encode(array $data): string
    {
        $json = json_encode($data);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonEncodingException(json_last_error_msg(), json_last_error());
        }

        return $json;
    }

    /**
     * @inheritdoc
     *
     */
    public function decode(string $json): array
    {
        $result = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonDecodingException(json_last_error_msg(), json_last_error());
        }

        if (!is_array($result)) {
            throw new JsonDecodingException('Claims are not in array format.');
        }

        return $result;
    }
}