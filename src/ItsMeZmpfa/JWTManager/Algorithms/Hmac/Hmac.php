<?php

namespace ItsMeZmpfa\JWTManager\Algorithms\Hmac;

use ItsMeZmpfa\JWTManager\Algorithms\ISigner;
use ItsMeZmpfa\JWTManager\Algorithms\IVerifier;
use ItsMeZmpfa\JWTManager\Algorithms\Keys\HmacKey;
use ItsMeZmpfa\JWTManager\Exception\InvalidKeyException;
use ItsMeZmpfa\JWTManager\Exception\InvalidSignatureException;
use ItsMeZmpfa\JWTManager\Exception\SigningException;
use ValueError;

class Hmac implements ISigner, IVerifier
{
    protected static string $name;

    protected HmacKey $key;

    public function __construct(HmacKey $key)
    {
        $this->key = $key;
    }

    /**
     * @inheritdoc
     */
    public function sign(string $message): string
    {
        try {
            if (strlen($this->key->getContent()) < 32 || strlen($this->key->getContent()) > 6144) {
                throw new InvalidKeyException('Key length must be between 32 and 6144.');
            }
            return hash_hmac($this->algorithm(), $message, $this->key->getContent(), true);
        } catch (ValueError | InvalidKeyException $e) {
            throw new SigningException('Cannot sign the signature.', 0, $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function verify(string $plain, string $signature): void
    {
        if ($signature !== $this->sign($plain)) {
            throw new InvalidSignatureException();
        }
    }

    /**
     * Generate algorithm name based on the key name
     */
    protected function algorithm(): string
    {
        return 'sha' . substr($this->name(), 2);
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return static::$name;
    }

    /**
     * @inheritDoc
     */
    public function kid(): ?string
    {
        return $this->key->getId();
    }

    public function getKey(): HmacKey
    {
        return $this->key;
    }
}