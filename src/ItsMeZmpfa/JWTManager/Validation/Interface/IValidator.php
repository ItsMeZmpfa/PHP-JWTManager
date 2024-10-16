<?php

namespace ItsMeZmpfa\JWTManager\Validation\Interface;

use ItsMeZmpfa\JWTManager\Exception\ValidationException;

interface IValidator
{
    /**
     * Validate the given claims
     *
     * @param string[] $claims
     * @throws ValidationException
     */
    public function validate(array $claims);
}