<?php

namespace ItsMeZmpfa\JWTManager;

use ItsMeZmpfa\JWTManager\Algorithms\Hmac\HS512;
use ItsMeZmpfa\JWTManager\Algorithms\Keys\HmacKey;
use ItsMeZmpfa\JWTManager\Validation\DefaultValidator;

class Core
{


    /**
     * @var Generator|null
     */
    protected ?Generator $generator = null;

    protected ?DefaultValidator $defaultValidator = null;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->defaultValidator = new DefaultValidator();

        $this->generator = new Generator($this->getSigner());
    }

    /**
     *  Create JWT Token
     * @param  array  $payload
     * @return string
     */
    public function generateJWT(array $payload):string
    {
        return $this->generator->generate($payload);
    }

    /**
     *
     * @param  string  $jwt
     * @return array
     * @throws Exception\InvalidTokenException
     * @throws Exception\ValidationException
     */
    public function parseJWT(string $jwt): array
    {
        $parser = new Parser($this->getSigner(), $this->defaultValidator);

        return $parser->parse($jwt);
    }

    /**
     *
     * @return mixed
     */
    public function getSigner(): mixed
    {
        return new HS512(new HmacKey($_ENV["JWT_SECRET_KEY"]));
    }

}