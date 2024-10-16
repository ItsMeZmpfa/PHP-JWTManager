<?php

namespace ItsMeZmpfa\JWTManager\Base64Url;

use ItsMeZmpfa\JWTManager\Base64Url\Interface\IBase64Url;

class Base64Url implements IBase64Url
{
    /**
     * @inheritdoc
     */
    public function encode(string $data): string
    {
        return str_replace('=', '', strtr(base64_encode($data), '+/', '-_'));
    }

    /**
     * @inheritdoc
     */
    public function decode(string $data): string
    {
        if ($remainder = strlen($data) % 4) {
            $paddingLength = 4 - $remainder;
            $data .= str_repeat('=', $paddingLength);
        }

        return base64_decode(strtr($data, '-_', '+/'));
    }
}