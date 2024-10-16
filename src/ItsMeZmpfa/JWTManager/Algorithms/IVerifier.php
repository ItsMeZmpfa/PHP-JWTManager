<?php

namespace ItsMeZmpfa\JWTManager\Algorithms;

use ItsMeZmpfa\JWTManager\Exception\InvalidSignatureException;
use ItsMeZmpfa\JWTManager\Exception\SigningException;

interface IVerifier
{
    /**
     * Verify JWT signature
     *
     * @throws InvalidSignatureException
     * @throws SigningException
     */
    public function verify(string $plain, string $signature): void;

    /**
     * Retrieve the kid (Key ID)
     *
     * @return string|null It returns null if no kid is specified and a string if a key is specified.
     */
    public function kid(): ?string;
}