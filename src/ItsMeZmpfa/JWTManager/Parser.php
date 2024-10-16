<?php


namespace ItsMeZmpfa\JWTManager;


use ItsMeZmpfa\JWTManager\Algorithms\IVerifier;
use ItsMeZmpfa\JWTManager\Base64Url\Base64Url;
use ItsMeZmpfa\JWTManager\Base64Url\Interface\IBase64Url;
use ItsMeZmpfa\JWTManager\Exception\InvalidTokenException;
use ItsMeZmpfa\JWTManager\Exception\ValidationException;
use ItsMeZmpfa\JWTManager\Json\Interface\IJsonParser;
use ItsMeZmpfa\JWTManager\Json\JsonParser;
use ItsMeZmpfa\JWTManager\Validation\BaseValidator;
use ItsMeZmpfa\JWTManager\Validation\Interface\IValidator;

class Parser
{
    private IVerifier $verifier;

    private IValidator $validator;

    private IJsonParser $jsonParser;

    private IBase64Url $base64Url;

    public function __construct(
        IVerifier $verifier,
        ?IValidator $validator = null,
        ?IJsonParser $jsonParser = null,
        ?IBase64Url $base64Parser = null
    ) {
        $this->verifier = $verifier;
        $this->validator = $validator ?: new BaseValidator();
        $this->jsonParser = $jsonParser ?: new JsonParser();
        $this->base64Url = $base64Parser ?: new Base64Url();
    }

    /**
     *  Parse (verify, decode, and validate) the JWT and extract claims
     * @param  string  $jwt
     * @return array
     * @throws ValidationException
     * @throws InvalidTokenException
     */
    public function parse(string $jwt): array
    {
        [$header, $payload, $signature] = $this->split($jwt);

        $this->validateHeader($header);

        $this->verifySignature($header, $payload, $signature);

        $claims = $this->decode($payload);

        $this->validator->validate($claims);

        return $claims;
    }

    /**
     *  Split (explode) JWT to its components
     *
     * @param  string  $jwt
     * @return array
     * @throws InvalidTokenException
     */
    private function split(string $jwt): array
    {
        $sections = explode('.', $jwt);

        if (count($sections) !== 3) {
            throw new InvalidTokenException('JWT format is not valid.');
        }

        return $sections;
    }

    /**
     * Verify the JWT (verify the signature)
     *
     * @param  string  $jwt
     * @return void
     * @throws InvalidTokenException
     */
    public function verify(string $jwt): void
    {
        [$header, $payload, $signature] = $this->split($jwt);

        $this->verifySignature($header, $payload, $signature);
    }

    /**
     * Verify the JWT signature
     *
     * @param  string  $header
     * @param  string  $payload
     * @param  string  $signature
     * @return void
     */
    private function verifySignature(string $header, string $payload, string $signature): void
    {
        $signature = $this->base64Url->decode($signature);

        $this->verifier->verify("$header.$payload", $signature);
    }

    /**
     *  Decode JWT and extract claims
     * @param  string  $payload
     * @return array
     */
    private function decode(string $payload): array
    {
        return $this->jsonParser->decode($this->base64Url->decode($payload));
    }

    /**
     *  Validate JWT (verify signature and validate claims)
     * @param  string  $jwt
     * @return void
     * @throws InvalidTokenException|ValidationException
     */
    public function validate(string $jwt): void
    {
        [$header, $payload, $signature] = $this->split($jwt);

        $this->verifySignature($header, $payload, $signature);

        $claims = $this->decode($payload);

        $this->validator->validate($claims);
    }

    /**
     * Validate JWT Header
     * @param  string  $header
     * @return void
     * @throws InvalidTokenException
     */
    public function validateHeader(string $header): void
    {
        $fields = $this->jsonParser->decode($this->base64Url->decode($header));

        if (!isset($fields['typ'])) {
            throw new InvalidTokenException('JWT header does not have `typ` field.');
        }
        if ($fields['typ'] !== 'JWT') {
            throw new InvalidTokenException("JWT of type `{$fields['typ']}` is not supported.");
        }

        if (isset($fields['kid'])) {
            if ($fields['kid'] !== $this->verifier->kid()) {
                throw new InvalidTokenException("The kid is not compatible with key ID.");
            }
        }
    }

    public function getJsonParser(): IJsonParser
    {
        return $this->jsonParser;
    }

    public function getBase64Parser(): IBase64Url
    {
        return $this->base64Url;
    }

    public function getVerifier(): IVerifier
    {
        return $this->verifier;
    }

    public function getValidator(): IValidator
    {
        return $this->validator;
    }
}