<?php

namespace ItsMeZmpfa\JWTManager\Validation;

use ItsMeZmpfa\JWTManager\Exception\ValidationException;
use ItsMeZmpfa\JWTManager\Validation\Interface\IRule;
use ItsMeZmpfa\JWTManager\Validation\Interface\IValidator;

class BaseValidator implements IValidator
{
    /**
     * @var array<string,array>
     */
    protected array $rules = [];

    /**
     * Add a new required rule
     */
    public function addRequiredRule(string $claimName, IRule $rule): void
    {
        $this->rules[$claimName][] = [$rule, true];
    }

    /**
     * Add a new required rule
     */
    public function addOptionalRule(string $claimName, IRule $rule): void
    {
        $this->rules[$claimName][] = [$rule, false];
    }

    /**
     * @inheritDoc
     *
     */
    public function validate(array $claims): void
    {
        foreach ($this->rules as $claimName => $rules) {
            $exists = isset($claims[$claimName]);
            $value = $exists ? $claims[$claimName] : null;

            foreach ($rules as $ruleAndState) {
                /**
                 * @var IRule $rule
                 * @var bool $required
                 */
                [$rule, $required] = $ruleAndState;

                if ($exists) {
                    $rule->validate($claimName, $value);
                } elseif ($required) {
                    $message = "The `$claimName` is required.";
                    throw  new ValidationException($message);
                }
            }
        }
    }


}