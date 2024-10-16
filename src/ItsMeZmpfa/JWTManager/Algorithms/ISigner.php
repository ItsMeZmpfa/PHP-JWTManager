<?php

namespace ItsMeZmpfa\JWTManager\Algorithms;

use ItsMeZmpfa\JWTManager\Exception\SigningException;

interface ISigner
{
    /**
     * Retrieve the signer name
     */
    public function name(): string;

    /**
     * Retrieve the kid (Key ID)
     *
     * @return string|null It returns null if no kid is specified and a string if a key is specified.
     */
    public function kid(): ?string;

    /**
     * Sign the message
     *
     * @throws SigningException
     */
    public function sign(string $message): string;
}