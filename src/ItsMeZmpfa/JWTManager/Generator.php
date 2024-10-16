<?php

namespace ItsMeZmpfa\JWTManager;

use ItsMeZmpfa\JWTManager\Algorithms\ISigner;
use ItsMeZmpfa\JWTManager\Base64Url\Base64Url;
use ItsMeZmpfa\JWTManager\Base64Url\Interface\IBase64Url;
use ItsMeZmpfa\JWTManager\Json\Interface\IJsonParser;
use ItsMeZmpfa\JWTManager\Json\JsonParser;

class Generator
{
    protected ISigner $signer;

    protected IJsonParser $jsonParser;

    protected IBase64Url $base64Parser;

    public function __construct(ISigner $signer, IJsonParser $jsonParser = null, IBase64Url $base64Parser = null)
    {
        $this->signer = $signer;
        $this->jsonParser = $jsonParser ?: new JsonParser();
        $this->base64Parser = $base64Parser ?: new Base64Url();
    }

    /**
     *  Generate JWT for the given claims
     * @param  array  $claims
     * @return string
     */
    public function generate(array $claims = []): string
    {

        $header = $this->base64Parser->encode($this->jsonParser->encode($this->header()));
        $payload = $this->base64Parser->encode($this->jsonParser->encode($claims));
        $signature = $this->base64Parser->encode($this->signer->sign("$header.$payload"));

        return join('.', [$header, $payload, $signature]);
    }

    /**
     *  Generate the JWT header
     * @return array
     */
    private function header(): array
    {
        $header = ['typ' => 'JWT', 'alg' => $this->signer->name()];
        if ($this->signer->kid() !== null) {
            $header['kid'] = $this->signer->kid();
        }
        return $header;
    }

    public function getJsonParser(): IJsonParser
    {
        return $this->jsonParser;
    }

    public function getBase64Parser(): IBase64Url
    {
        return $this->base64Parser;
    }

    public function getSigner(): ISigner
    {
        return $this->signer;
    }
}
