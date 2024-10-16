<?php

namespace ItsMeZmpfa\JWTManager\Validation\Rule;

use ItsMeZmpfa\JWTManager\Exception\ValidationException;
use ItsMeZmpfa\JWTManager\Validation\Interface\IRule;

class MustBeTheSameRule implements IRule
{
    /**
     * @var mixed
     */
    private mixed $value;

    /**
     * @param mixed $value
     */
    public function __construct(mixed $value)
    {
        $this->value = $value;
    }


    /**
     * @inheritDoc
     */
    public function validate(string $name, $value): void
    {
        if ($this->value != $value) {
            $message = "The `$name` must equal to `$this->value`.";
            throw new ValidationException($message);
        }
    }
}