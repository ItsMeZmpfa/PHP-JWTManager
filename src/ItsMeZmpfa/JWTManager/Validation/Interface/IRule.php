<?php

namespace ItsMeZmpfa\JWTManager\Validation\Interface;

use ItsMeZmpfa\JWTManager\Exception\ValidationException;

interface IRule
{
    /**
     *   Validate the given value
     * @param  string  $name
     * @param $value
     * @return void
     * @throws ValidationException
     */
    public function validate(string $name, $value): void;
}